<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\FCM;

class Notification extends Model{
    
    public static function addUnreadPublication($followers, $authorId){
        foreach(array_unique(array_column($followers->toArray(), 'followerId')) as $follower){
            DB::table('unread_notification')->insert(['action' => 'PUBLICATION', 'actionId' => $authorId, 'userId' => $follower]);
        }
    }
    
    public static function sendPublication($me, $followers, $publication){
        $muted    = array();
        $unmuted  = array();
        foreach($followers as $follower){
            if(!$follower->muted)
                $unmuted[] = $follower->fcm;
            else
                $muted[] = $follower->fcm;
        }
        
        $data = array(
            "title"         => $me->name,
            "message"       => "📰 " . $publication->description, //📷🔗📽️
            "notId"         => $me->id,
            "priority"      => 2,
            "icon"          => "notification_small_icon",
            "color"         => "#867446",
            "summaryText"   => "%n% publicações novas",
            "style"         => "inbox",
            "authorId"      => $me->authorId,
            "publicationId" => $publication->id,
            "type"          => "publication"
        );
        FCM::notification($unmuted, $data);
        
        unset($data['title'], $data['message']);
        FCM::notification($muted, $data);
    }
    
    public static function clearUnreadNotification($me, $action, $actionId){
        $query = DB::table('unread_notification')->where('userId', $me)->where('action', $action);
        if($actionId)
            $query->where('actionId', $actionId);
        return $query->delete();
    }
    
}
