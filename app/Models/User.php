<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Utils\Obscure;
use App\Utils\TransformObscure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Utils\ActionEnum;
use App\Utils\UserListEnum;
use App\Models\Notification;
use App\Builder\PushBuilder;


class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['name', 'email', 'password', 'username','image'];
    public $timestamps = false;
    
    public static function storeImage($userId, $image){
        $filename = $image->store('img/user/'.Obscure::user($userId), 's3'); //env('APP_ENV') ? $image->store('img/'.$userId) : $image->store('img/'.$userId, 's3');
        if($filename){
            Storage::disk('s3')->delete(DB::table('user')->where('id', $userId)->value('image'));
            DB::table('user')->where('id', $userId)->update(['image' => $filename]);
            return $filename;
        }
        return false;
    }
    
    public static function follow($users, $me){
        $data = array();
        foreach($users as $user){
            DB::table('relation')->insert(['followerId' => $me->auth->userId, 'followingId' => $user, 'muted' => true]);
            Notification::insertRelation(ActionEnum::RELATION, $user);
            PushBuilder::relation($me, $user);
        }
        return true;
    }
    
    public static function me($userId){
        if(DB::table('author')->where('userId', $userId)->first()){
            $data = TransformObscure::author(DB::table('user')
                ->join('author', 'user.id', '=', 'author.userId')
                ->where('user.id', $userId)
                ->where('disabled', false)
                ->first([
                    'user.*','author.*', 'author.id AS authorId',
                    DB::raw("(SELECT COUNT(*) FROM `like` INNER JOIN publication ON `like`.publicationId = publication.id WHERE publication.authorId = author.id) AS likes"),
                    DB::raw("(SELECT COUNT(*) FROM relation WHERE followingId = user.id) AS followers"),
                    DB::raw("(SELECT COUNT(*) FROM publication WHERE authorId = author.id) AS publications")
                ]));
        }else{
            $data = TransformObscure::user(DB::table('user')
            ->where('id', $userId)
            ->where('disabled', false)
            ->first([
                'user.*', 'user.id AS userId',
                DB::raw("(SELECT COUNT(*) FROM relation WHERE followerId = user.id) AS following"),
            ]));
        }
        $data->badge = DB::table('notification')->where('userId', $userId)->where('read', false)->count();
        unset($data->id);
        unset($data->password);
        return $data;
    }
    
    public static function unfollow($me, $user){
        return DB::table('relation')->where('followerId', $me)->where('followingId', $user)->delete();
    }
    
    public static function authorToFeed($me){
        return TransformObscure::authorList(DB::table('relation')
            ->join('user', 'relation.followingId', '=', 'user.id')
            ->join('author', 'author.userId', '=', 'user.id')
            ->where('relation.followerId', $me)
            ->where('user.disabled', false)
            ->orderBy('idLastPublication', 'DESC')
            ->get(['user.id as userId', 'user.name', 'relation.muted',
                   'author.id AS authorId', 'user.username','user.image',
                   DB::raw("(SELECT publication.id FROM publication WHERE authorId = author.id ORDER BY publication.id DESC LIMIT 1) AS idLastPublication"),
                   DB::raw("(SELECT COUNT(*) FROM unread_notification WHERE unread_notification.userId = $me AND unread_notification.action = 'PUBLICATION' AND unread_notification.actionId = author.id) AS badge")
            ]));
    }
    
    public static function following($me, $offset){
        return TransformObscure::authorList(DB::table('relation')
            ->join('user', 'relation.followingId', '=', 'user.id')
            ->join('author', 'author.userId', '=', 'user.id')
            ->where('relation.followerId', $me)
            ->where('user.disabled', false)
            ->orderBy('user.name')
            ->orderBy('user.username')
            ->offset($offset)
            ->limit(config('global.followingLimit'))
            ->get(['user.name', 'relation.muted', 'user.id AS userId',
                'author.id AS authorId', 'user.username','user.image',
            ]));
    }
    
    public static function like($me, $publicationId){
        if(DB::table('like')->where('userId', $me->auth->userId)->where('publicationId', $publicationId)->first()){
            return false;
        }
        DB::table('like')->insert(['userId' => $me->auth->userId, 'publicationId' => $publicationId]);
        $user = DB::table('publication')->join('author','publication.authorId','=','author.id')->where('publication.id', $publicationId)->value('userId');
        Notification::insertLike(ActionEnum::LIKE, $user, $publicationId);
        PushBuilder::like($me, $user);
        return true;
    }
    
    public static function unlike($me, $publicationId){
        return DB::table('like')->where('userId', $me)->where('publicationId', $publicationId)->delete();
    }
    
    public static function savePublication($me, $publicationId){
        if(DB::table('save')->where('userId', $me)->where('publicationId', $publicationId)->first()){
            return false;
        }
        return DB::table('save')->insert(['userId' => $me, 'publicationId' => $publicationId]);
    }
    
    public static function unsave($me, $publicationId){
        return DB::table('save')->where('userId', $me)->where('publicationId', $publicationId)->delete();
    }
    
    public static function mute($me, $userId){
        return DB::table('relation')->where('followerId', $me)->where('followingId', $userId)->update(['muted' => true]);
    }
    
    public static function unmute($me, $userId){
        return DB::table('relation')->where('followerId', $me)->where('followingId', $userId)->update(['muted' => false]);
    }
    
    public static function profile($me, $userId){
        if(DB::table('author')->where('userId', $userId)->first()){
            return TransformObscure::author(DB::table('author')
                ->join('user', 'author.userId', '=', 'user.id')
                ->where('user.id', $userId)
                ->where('user.disabled', false)
                ->first(['user.id AS userId', 'name', 'username', 'image','folderId',
                    'author.id AS authorId', 'bio', 'facebook', 'twitter', 'youtube', 'facebook','site', 'gab', 'instagram',
                    DB::raw("(SELECT COUNT(*) FROM `like` INNER JOIN publication ON `like`.publicationId = publication.id WHERE publication.authorId = author.id) AS likes"),
                    DB::raw("(SELECT COUNT(*) FROM relation WHERE followingId = user.id) AS followers"),
                    DB::raw("(SELECT COUNT(*) FROM publication WHERE authorId = author.id) AS publications"),
                    ($me ? DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `relation` WHERE followingId = user.id AND followerId = $me AND muted = true) AS muted") : ""),
                    ($me ? DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM relation WHERE followingId = user.id AND followerId = $me) AS followed") : "")
                ]));
        }else{
            return TransformObscure::user(DB::table('user')
                ->where('user.id', $userId)
                ->first(['user.id AS userId', 'name', 'username', 'image',
                    DB::raw("(SELECT COUNT(*) FROM relation WHERE followingId = user.id) AS following")
                ]));
        }
    }
    
    public static function liked_publications($me, $offset){
        $liked = DB::table('like')->where('userId', $me)->pluck('publicationId');
        $query     = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->join('like', 'like.publicationId', '=', 'publication.id')
            ->whereIn('publication.id', $liked)
            ->where('publication.draft', false)
            ->orderBy('like.date', 'DESC')
            ->offset($offset)
            ->limit(config('global.searchPublicationsHome'));
        $publications = $query->get(['publication.id','publication.linkId', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId','folderId',
            DB::raw("(SELECT COUNT(*) FROM `like` WHERE publicationId = publication.id) AS likes"),
            DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM save WHERE publicationId = publication.id AND userId = $me) AS saved")
        ]);
        foreach($publications as $publication){
            $publication = PublicationBuilder::toFeed($publication);
            $publication->liked = true;
        }
        return $publications;
    }
    
    public static function saved_publications($me, $offset){
        $saved = DB::table('save')->where('userId', $me)->pluck('publicationId');
        $query     = DB::table('publication')
            ->join('author', 'publication.authorId', '=', 'author.id')
            ->join('user', 'author.userId', '=', 'user.id')
            ->join('save', 'save.publicationId', '=', 'publication.id')
            ->whereIn('publication.id', $saved)
            ->where('publication.draft', false)
            ->orderBy('save.date', 'DESC')
            ->offset($offset)
            ->limit(config('global.searchPublicationsHome'));
        $publications = $query->get(['publication.id','publication.linkId', 'publication.title', 'publication.description', 'publication.date', 'publication.authorId', 
            'user.username', 'user.name', 'user.image', 'author.userId','folderId',
            DB::raw("(SELECT COUNT(*) FROM `like` WHERE publicationId = publication.id) AS likes"),
            DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `like` WHERE publicationId = publication.id AND userId = $me) AS liked")
        ]);
        foreach($publications as $publication){
            $publication = PublicationBuilder::toFeed($publication);
            $publication->saved = true;
        }
        return $publications;
    }
    
    public static function updateUser($data){
        $user = [
            'name' => $data->name,
            'username' => $data->username,
            'email'    => $data->email,
        ];
        if(!empty($data->removeImage)){
            $user['image'] = NULL;
            Storage::disk('s3')->delete(DB::table('user')->where('id', $data->auth->userId)->value('image'));
        }
        DB::table('user')->where('id', $data->auth->userId)->update($user);
        if($data->auth->authorId){
            DB::table('author')->where('id', $data->auth->authorId)->update([
                'bio'       => $data->bio,
                'site'      => $data->site,
                'gab'       => $data->gab,
                'youtube'   => $data->youtube,
                'facebook'  => $data->facebook,
                'instagram' => $data->instagram,
                'twitter'   => $data->twitter
            ]);
        }
        return true;
    }
    
    public static function list($data, $offset){
        $query = DB::table('user');
        switch($data->type){
            case UserListEnum::FOLLOWING:
                $query->join('relation', 'relation.followingId', '=', 'user.id')
                    ->where('relation.followerId', $data->userId)
                    ->orderBy('relation.date', 'DESC');
                break;
            case UserListEnum::FOLLOWERS:
                $query->join('relation', 'relation.followerId', '=', 'user.id')
                    ->where('relation.followingId', $data->userId)
                    ->orderBy('relation.date', 'DESC');
                break;
            case UserListEnum::FOLLOWED:
                break;
            case UserListEnum::LIKED:
                $query->join('like', 'like.userId', '=', 'user.id')
                    ->where('like.publicationId', $data->publicationId)
                    ->orderBy('like.date', 'DESC');
                break;
            case UserListEnum::COMMENT:
                break;
        }
        
        $query->where('user.disabled', false)
            ->orderBy('user.name')
            ->orderBy('user.username')
            ->offset($offset)
            ->limit(config('global.userListLimit'));
        
        $users = $query->get(['user.id AS userId', 'user.name', 'user.username','user.image']);
        return TransformObscure::userList($users);
    }
    
    public static function updateUserPassword($data){
        return DB::table('user')->where('id', $data->auth->userId)->update(['password' => Hash::make($data->newPassword)]);
    }
    
}
