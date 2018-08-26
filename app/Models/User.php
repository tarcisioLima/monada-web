<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = false;
    
    public static function follow($users, $me){
        $data = array();
        foreach($users as $user){
            if($user == $me){
                return ['msg' => 'Você não pode você seguir a si próprio'];
            }
            if(DB::table('relation')->where('followerId', $me)->where('followingId', $user)->first()){
                return ['msg' => 'Você já está seguindo este usuário'];
            }
            if(User::find($user)){
                $data[] = ['followerId' => $me, 'followingId' => $user, 'muted' => true];
            }
        }
        if(empty($data)){
            return ['msg' => 'O usuário não existe'];
        }
        if(!DB::table('relation')->insert($data)){
            return ['msg' => 'Houve um erro ao seguir este usuário'];
        }
        return ['msg' => 'Usuário seguido com sucesso', 'data' => true];
    }
    
    public static function unfollow($me, $user){
        return DB::table('relation')->where('followerId', $me)->where('followingId', $user)->delete();
    }
    
    public static function authorToFeed($me){
        return DB::table('relation')
            ->join('user', 'relation.followingId', '=', 'user.id')
            ->join('author', 'author.userId', '=', 'user.id')
            ->where('relation.followerId', $me)
            ->where('author.actived', true)
            ->orderBy('idLastPublication', 'DESC')
            ->get(['user.id as userId', 'user.name', 'relation.muted',
                   'author.id AS authorId', 'user.username','user.image',
                   DB::raw("(SELECT publication.id FROM publication WHERE authorId = author.id ORDER BY publication.id DESC LIMIT 1) AS idLastPublication"),
                   DB::raw("(SELECT COUNT(*) FROM unread_notification WHERE unread_notification.userId = $me AND unread_notification.action = 'PUBLICATION' AND unread_notification.actionId = author.id) AS badge")]);
    }
    
    public static function following($me, $offset){
        return DB::table('relation')
            ->join('user', 'relation.followingId', '=', 'user.id')
            ->join('author', 'author.userId', '=', 'user.id')
            ->where('relation.followerId', $me)
            ->where('author.actived', true)
            ->orderBy('user.name')
            ->orderBy('user.username')
            ->offset($offset)
            ->limit(config('global.followingLimit'))
            ->get(['user.name', 'relation.muted', 'user.id AS userId','author.id AS authorId',
                'author.id AS authorId', 'user.username','user.image',
            ]);
    }
    
    public static function like($me, $publicationId){
        if(DB::table('like')->where('userId', $me)->where('publicationId', $publicationId)->first()){
            return false;
        }
        return DB::table('like')->insert(['userId' => $me, 'publicationId' => $publicationId]);
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
            return DB::table('author')
                ->join('user', 'author.userId', '=', 'user.id')
                ->where('user.id', $userId)
                ->where('author.actived', true)
                ->get(['user.id AS userId', 'name', 'username', 'image',
                    'author.id AS authorId', 'bio', 'facebook', 'twitter', 'youtube', 'facebook','site',
                    DB::raw("(SELECT COUNT(*) FROM `like` INNER JOIN publication ON `like`.publicationId = publication.id WHERE publication.authorId = author.id) AS likes"),
                    DB::raw("(SELECT COUNT(*) FROM relation WHERE followingId = user.id) AS followers"),
                    DB::raw("(SELECT COUNT(*) FROM publication WHERE authorId = author.id) AS publications"),
                    ($me ? DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM `relation` WHERE followingId = user.id AND followerId = $me AND muted = true) AS muted") : ""),
                    ($me ? DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM relation WHERE followingId = user.id AND followerId = $me) AS followed") : "")
                ])->first();
        }else{
            return DB::table('user')
                ->where('user.id', $userId)
                ->get(['user.id AS userId', 'name', 'username', 'image',
                    DB::raw("(SELECT COUNT(*) FROM relation WHERE followingId = user.id) AS following")
                ])->first();
        }
    }
    
}
