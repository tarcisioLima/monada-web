<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Builder\PublicationBuilder;
use App\Utils\LinkHelper;
use App\Utils\Obscure;
use Illuminate\Support\Facades\Storage;


class Publication extends Model
{
    protected $table    = 'publication';
    protected $fillable = ['title', 'description', 'draft', 'authorId', 'folderId', 'linkId'];
    public $timestamps = false;
    
    public static function storeImage($userId, $image){
        $filename = $image->store('img/user/'.Obscure::user($userId).'/publication', 's3');
        if($filename){
            $imageId = DB::table('image')->insertGetId(['name' => $filename]);
            return ['imageId' => Obscure::image($imageId),'name' => ENV('AWS_IMAGE_URL') . $filename];
        }
        return false;
    }
    
    public static function addCategory($category, $publicationId){
        foreach($category as $categoryId){
            DB::table('publication_category')->insert(['categoryId' => $categoryId, 'publicationId' => $publicationId]);
        }
    }
    
    public static function addImages($images, $publicationId){
        foreach($images as $imageId){
            DB::table('image')->where('id', $imageId)->update(['publicationId' => $publicationId]);
        }
    }
    
    public static function addLink($link){
        $link = LinkHelper::linkToStore($link);
        $existentLink = DB::table('link')->where('url', $link['url'])->first();
        if(!empty($existentLink)){
            DB::table('link')->where('id', $existentLink->id)->update($link);
            return $existentLink->id;
        }else{
            return DB::table('link')->insertGetId($link);
        }
    }
    
    public static function byAuthor($me, $authorId, $offset, $last = null, $folderId = null){
        $query = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('author.id', $authorId)
            ->where('publication.draft', false)
            ->orderBy('publication.id', 'DESC')
            ->orderBy('publication.date', 'DESC');
        if($last){
            $query->where('publication.id', ">", $last);
        }else{
            $query->offset($offset);
            $query->limit(config('global.searchPublicationsHome'));
        }
        if($folderId){
            $query->where('publication.folderId', $folderId);
        }
        $publications = $query->get(['publication.id','publication.linkId', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId','folderId',
            DB::raw("(SELECT COUNT(*) FROM `like` WHERE publicationId = publication.id) AS likes"),
            ($me ? DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `like` WHERE publicationId = publication.id AND userId = $me) AS liked") : ""),
            ($me ? DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM save WHERE publicationId = publication.id AND userId = $me) AS saved") : "")
        ]);
        foreach($publications as $publication){
            $publication = PublicationBuilder::toFeed($publication);
        }
        return $publications;
    }
    
    public static function byFollowing($me, $offset, $last = null){
        $following = DB::table('relation')->where('followerId', $me)->pluck('followingId');
        $following[] = $me;
        $query     = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->whereIn('author.userId', $following)
            ->where('publication.draft', false)
            ->orderBy('publication.id', 'DESC')
            ->orderBy('publication.date', 'DESC');
        if($last){
            $query->where('publication.id', ">", $last);
        }else{
            $query->offset($offset);
            $query->limit(config('global.searchPublicationsHome'));
        }
        $publications = $query->get(['publication.id','publication.linkId', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId','folderId',
            DB::raw("(SELECT COUNT(*) FROM `like` WHERE publicationId = publication.id) AS likes"),
            DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `like` WHERE publicationId = publication.id AND userId = $me) AS liked"),
            DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM save WHERE publicationId = publication.id AND userId = $me) AS saved")
        ]);
        foreach($publications as $publication){
            $publication = PublicationBuilder::toFeed($publication);
        }
        return $publications;
    }
    
    public static function highlights($me, $offset){
        $publications = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('publication.draft', false)
            ->where('user.disabled', false)
            ->offset($offset)
            ->limit(config('global.searchPublicationsHome'))
            ->orderByRaw('CASE WHEN publication.date >= DATE_SUB(NOW(), INTERVAL 2 DAY)
                          THEN 0 ELSE 1 END')
            ->orderBy('likes', 'DESC')
            ->get(['publication.id','publication.linkId', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
                'user.username', 'user.name', 'user.image', 'author.userId','folderId',
                DB::raw("(SELECT COUNT(*) FROM `like` WHERE publicationId = publication.id) AS likes"),
                DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `like` WHERE publicationId = publication.id AND userId = $me) AS liked"),
                DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM save WHERE publicationId = publication.id AND userId = $me) AS saved")
            ]);
        foreach($publications as $publication){
            $publication = PublicationBuilder::toFeed($publication);
        }
        return $publications;
    }
    
    public static function search($me, $term, $author, $category, $since, $until, $offset, $folderId, $authorId){
        $publications = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('publication.draft', false)
            ->where('user.disabled', false)
            ->offset($offset)
            ->limit(config('global.searchPublicationsHome'))
            ->orderBy('publication.id', 'DESC')
            ->orderBy('publication.date', 'DESC')
            ->orderBy('likes', 'DESC');
        
        if($term){
            $publications->whereRaw("MATCH(publication.title, publication.description) AGAINST('$term' IN BOOLEAN MODE)");
        }
        if($author){
            $publications->where(function($query) use($author){
                $query->where('user.username', 'like', $author.'%')
                      ->orWhere('user.name', 'like', $author.'%');
            });
        }
        if($category){
            $publications->whereExists(function($query) use($category){
                $query->select(DB::raw(1))
                      ->from('publication_category')
                      ->whereRaw('publication_category.publicationId = publication.id')
                      ->whereIn('publication_category.categoryId', $category);
            });
        }
        if($since){
            $publications->whereDate('publication.date', '>=', $since);
        }
        if($until){
            $publications->whereDate('publication.date', '<=', $until);
        }
        
        if($folderId){
            $publications->where('publication.folderId', $folderId);
        }
        
        if($authorId){
            $publications->where('publication.authorId', $authorId);
        }
            
        $publications = $publications->get(['publication.id','publication.linkId', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId','folderId',
            DB::raw("(SELECT COUNT(*) FROM `like` WHERE publicationId = publication.id) AS likes"),
            DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `like` WHERE publicationId = publication.id AND userId = $me) AS liked"),
            DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM save WHERE publicationId = publication.id AND userId = $me) AS saved")
        ]);
        foreach($publications as $publication){
            $publication = PublicationBuilder::toFeed($publication);
        }
        return $publications;
    }
    
    public static function categories(){
        return DB::table('category')->orderBy('name')->get();
    }
    
    public static function updatePublication($data){
        $linkId = null;
        if(!empty($data->link)){
            $linkId = Publication::addLink($data->link);
        }
        
        $existentImages = DB::table('image')->where('publicationId', $data->id)->get();
        foreach($existentImages as $key => $image){
            if(!in_array($image->id, $data->images)){
                Storage::disk('s3')->delete($image->name);
                DB::table('image')->where('id', $image->id)->delete();
                unset($existentImages[$key]);
            }
        }
        $existentImages = array_column((array)$existentImages, 'id');//DB::table('image')->where('publicationId', $data->id)->pluck('id');
        foreach($data->images as $imageId){
            if(!in_array($imageId, $existentImages)){
                DB::table('image')->where('id', $imageId)->update(['publicationId' => $data->id]);
            }
        }
        
        DB::table('publication_category')->where('publicationId', $data->id)->delete();
        self::addCategory(isset($data->category) ? $data->category : [], $data->id);
        
        DB::table('publication')->where('id', $data->id)->update([
            'title'       => $data->title,
            'description' => $data->description,
            'folderId'    => $data->folderId,
            'linkId'      => $linkId,
        ]);
        
        return true;
    }
    
    public static function deletePublication($authorId, $publicationId){
        if(DB::table('publication')->where('id', $publicationId)->where('authorId', $authorId)->first()){
            DB::table('publication_category')->where('publicationId', $publicationId)->delete();
            $images = DB::table('image')->where('publicationId', $publicationId)->pluck('name');
            foreach($images as $image){
                 Storage::disk('s3')->delete($image);
            }
            DB::table('image')->where('publicationId', $publicationId)->delete();
            DB::table('save')->where('publicationId', $publicationId)->delete();
            DB::table('like')->where('publicationId', $publicationId)->delete();
            if(DB::table('publication')->where('id', $publicationId)->delete()){
                return true;
            }
            return false;
        }
        return false;
    }
    
}
