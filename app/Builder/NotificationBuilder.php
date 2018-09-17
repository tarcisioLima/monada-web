<?php

namespace App\Builder;

use Illuminate\Support\Facades\DB;
use App\Utils\TransformObscure;
use App\Utils\Obscure;

class NotificationBuilder
{
    const limit = 5;
    
    public static function toUser($notification){
        switch($notification->action){
            case 'RELATION':
                $notification = self::toRelation($notification);
                break;
            case 'LIKE':
                $notification = self::toLike($notification);
                break;
            case 'COMMENT':
                $notification = self::toComment($notification);
                break;
            case 'SYSTEM':
                $notification = self::toSystem($notification);
                break;
            case 'SECURITY':
                $notification = self::toSecurity($notification);
                break;
            default:
        }
        unset($notification->userId, $notification->read, $notification->actionId);
        return $notification;
    }
    
    public static function toRelation($notification){
        $followers = DB::table('relation')
                        ->join('user', 'relation.followerId', '=', 'user.id')
                        ->where('followingId', $notification->userId)
                        ->orderBy('relation.date', 'DESC')
                        ->limit(self::limit)
                        ->get(['user.id AS userId', 'user.username', 'user.image']);
                        
        $count = DB::table('relation')->where('followingId', $notification->userId)->count() - self::limit;
        $notification->count = $count > 0 ? $count : null;
        $notification->users = TransformObscure::userList($followers);
        return $notification;
    }
    
    public static function toLike($notification){
        $liker = DB::table('like')
                        ->join('user', 'like.userId', '=', 'user.id')
                        ->where('publicationId', $notification->actionId)
                        ->orderBy('like.date', 'DESC')
                        ->limit(self::limit)
                        ->get(['user.id AS userId', 'user.username', 'user.image']);
        $count = DB::table('like')->where('publicationId', $notification->actionId)->count() - self::limit;
        $notification->publicationId = Obscure::publication($notification->actionId);
        $notification->count = $count > 0 ? $count : null;
        $notification->users = TransformObscure::userList($liker);
        return $notification;
    }
    
    public static function toSystem($notification){
        $data = DB::table('system_notification')->where('id', $notification->actionId)->first();
        //->systemNotificationId = $notification->actionId;
        $notification->data = $data ? $data : (object)array();
        return $notification;
    }
    
    
}
