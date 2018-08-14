<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Author extends Model
{
    protected $table = 'author';
    public $timestamps = false;
    
    public static function search($filter, $offset){
        return DB::table('author')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('name', 'like', $filter.'%')
            ->orWhere('username', 'like', $filter.'%')
            ->orderBy('username')
            ->orderBy('name')
            ->offset($offset)
            ->limit(config('global.searchAuthorLimit'))
            ->get(['name', 'username', 'image', 'user.id']);
    }
    
    public static function suggestion($offset){
        return DB::table('author')
            ->join('user', 'author.userId', '=', 'user.id')
            ->orderBy('followers', 'DESC')
            ->orderBy('likes', 'DESC')
            ->orderBy('name', 'ASC')
            ->orderBy('username', 'ASC')
            ->offset($offset)
            ->limit(config('global.searchAuthorLimit'))
            ->get(['name', 'username', 'image', 'user.id', 
            DB::raw("(SELECT COUNT(*) FROM relation 
            WHERE followingId = author.userId) as followers"),
            DB::raw("(SELECT COUNT(*) FROM `like` INNER JOIN publication ON like.publicationId = publication.id 
            WHERE publication.authorId = author.id) as likes"),
            ]);
    }
    
    public static function followers($me){
        return DB::table('relation')
            ->join('device', 'relation.followerId', '=', 'device.userId')
            ->where('followingId', $me)
            ->get(['device.fcm','relation.followerId', 'relation.muted']);
    }
    
}
