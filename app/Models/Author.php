<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Author extends Model
{
    protected $table = 'author';
    public $timestamps = false;
    
    public static function search($me, $filter, $offset){
        return DB::table('author')
            ->join('user', 'author.userId', '=', 'user.id')
            ->where('name', 'like', $filter.'%')
            ->orWhere('username', 'like', $filter.'%')
            ->orderBy('name')
            ->orderBy('username')
            ->offset($offset)
            ->limit(config('global.searchAuthorLimit'))
            ->get(['name', 'username', 'image', 'user.id AS userId','author.id AS authorId',
                DB::raw("(SELECT IF(COUNT(*) = 0, false, true) FROM relation WHERE followingId = user.id AND followerId = $me) AS followed"),
            ]);
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
    
    public static function folder($authorId, $folderId = 0){
        $query = DB::table('folder')->where('authorId', $authorId);
        if($folderId) $query->where('id', $folderId);
        return $query->get();
    }
    
}
