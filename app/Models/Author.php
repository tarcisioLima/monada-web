<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Utils\TransformObscure;

class Author extends Model
{
    protected $table = 'author';
    public $timestamps = false;
    
    public static function store($userId, $invite){
        if($authorId = DB::table('author')->insertGetId(['userId' =>$userId])){
            DB::table('invite')->where('id', $invite)->delete();
            return $authorId;
        }
        return false;
    }
    
    public static function search($me, $filter, $offset){
        return TransformObscure::authorList(DB::table('author')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('name', 'like', $filter.'%')
            ->orWhere('username', 'like', $filter.'%')
            ->orderBy('name')
            ->orderBy('username')
            ->offset($offset)
            ->limit(config('global.searchAuthorLimit'))
            ->get(['name', 'username', 'image', 'user.id AS userId','author.id AS authorId',
                DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM relation WHERE followingId = user.id AND followerId = $me) AS followed"),
        ]));
    }
    
    public static function suggestion($offset){
        return TransformObscure::authorList(DB::table('author')
            ->join('user', 'author.userId', '=', 'user.id')
            ->orderBy('followers', 'DESC')
            ->orderBy('likes', 'DESC')
            ->orderBy('name', 'ASC')
            ->orderBy('username', 'ASC')
            ->offset($offset)
            ->limit(config('global.searchAuthorLimit'))
            ->get(['name', 'username', 'image', 'user.id AS userId', 'author.id AS authorId', 
            DB::raw("(SELECT COUNT(*) FROM relation 
            WHERE followingId = author.userId) as followers"),
            DB::raw("(SELECT COUNT(*) FROM `like` INNER JOIN publication ON like.publicationId = publication.id 
            WHERE publication.authorId = author.id) as likes"),
        ]));
    }
    
    public static function followers($me){
        return DB::table('relation')
            ->join('device', 'relation.followerId', '=', 'device.userId')
            ->where('followingId', $me)
            ->get(['device.fcm','relation.followerId', 'relation.muted']);
    }
    
    
}
