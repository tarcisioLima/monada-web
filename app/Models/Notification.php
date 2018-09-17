<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Utils\FCM;
use App\Builder\NotificationBuilder;
use App\Utils\ActionEnum;

class Notification extends Model{
    
    public static function addUnreadPublication($followers, $authorId){
        foreach(array_unique(array_column($followers->toArray(), 'followerId')) as $follower){
            DB::table('unread_notification')->insert(['action' => 'PUBLICATION', 'actionId' => $authorId, 'userId' => $follower]);
        }
    }
    
    public static function clearUnreadNotification($me, $action, $actionId){
        $query = DB::table('unread_notification')->where('userId', $me)->where('action', $action);
        if($actionId)
            $query->where('actionId', $actionId);
        return $query->delete();
    }
    
    public static function readNotifications($me){
        return DB::table('notification')->where('userId', $me)->where('read', false)->update(['read' => true]);
    }
    
    public static function show($me, $offset){
        $notifications = DB::table('notification')
            ->where('userId', $me)
            ->orderBy('date', 'DESC')
            ->offset($offset)
            ->limit(config('global.userNotifications'))
            ->get(['userId', 'actionId', 'action', 'date']);
        foreach($notifications as $notification){
            $notification = NotificationBuilder::toUser($notification);
        }
        return $notifications;
    }
    
    public static function insertRelation($action, $userId, $actionId = null, $read = false){
        if(DB::table('notification')->where('action', $action)->where('userId', $userId)->exists()){
            DB::table('notification')->where('action', $action)->where('userId', $userId)->update(['date' => date("Y-m-d H:i:s")]);
        }else{
            DB::table('notification')->insert(['action' => $action,'userId' => $userId,'actionId' => $actionId,'read' => $read]);
        }
    }
    
    public static function insertLike($action, $userId, $actionId = null, $read = false){
        if(DB::table('notification')->where('action', $action)->where('userId', $userId)->where('actionId', $actionId)->exists()){
            DB::table('notification')->where('action', $action)->where('userId', $userId)->where('actionId', $actionId)->update(['date' => date("Y-m-d H:i:s")]);
        }else{
            DB::table('notification')->insert(['action' => $action,'userId' => $userId,'actionId' => $actionId,'read' => $read]);
        }
    }
    
    public static function insertSystem($action, $actionId = null, $read = false){
        $data = array();
        foreach(DB::table('user')->pluck('id') as $userId){
            $data[] = ['action' => $action,'userId' => $userId,'actionId' => $actionId,'read' => $read];
        }
        DB::table('notification')->insert($data);
    }
    
}
