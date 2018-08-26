<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\PublicationBuilder;

class Publication extends Model
{
    protected $table    = 'publication';
    protected $fillable = ['title', 'description', 'link', 'draft', 'authorId', 'folderId'];
    public $timestamps = false;
    
    public static function addCategory($category, $publicationId){
        foreach($category as $categoryId){
            DB::table('publication_category')->insert(['categoryId' => $categoryId, 'publicationId' => $publicationId]);
        }
    }
    
    public static function addImages($images, $publicationId){
        foreach($images as $image){
            $filename = APP_ENV('local') ? $image->store('img/publication') : $image->store('img/publication', 's3');
            DB::table('image')->insert(['name' => $filename, 'publicationId' => $publicationId]);
        }
    }
    
    public static function byAuthor($me, $authorId, $offset, $last = null, $folderId = null){
        $query = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('author.id', $authorId)
            ->where('publication.draft', false)
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
        $publications = $query->get(['publication.id','publication.link', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId',
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
        $query     = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->whereIn('author.userId', $following)
            ->where('publication.draft', false)
            ->orderBy('publication.date', 'DESC');
        if($last){
            $query->where('publication.id', ">", $last);
        }else{
            $query->offset($offset);
            $query->limit(config('global.searchPublicationsHome'));
        }
        $publications = $query->get(['publication.id','publication.link', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId',
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
            ->where('author.actived', true)
            ->offset($offset)
            ->limit(config('global.searchPublicationsHome'))
            ->orderByRaw('CASE WHEN publication.date >= DATE_SUB(NOW(), INTERVAL 2 DAY)
                          THEN 0 ELSE 1 END')
            ->orderBy('likes', 'DESC')
            ->get(['publication.id','publication.link', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
                'user.username', 'user.name', 'user.image', 'author.userId',
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
            ->where('author.actived', true)
            ->offset($offset)
            ->limit(config('global.searchPublicationsHome'))
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
            
        $publications = $publications->get(['publication.id','publication.link', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId',
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
    
}
