<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\FCM;

class Notification extends Model{
    
    public static function addUnreadPublication($followers, $publicationId){
        foreach(array_unique(array_column($followers->toArray(), 'followerId')) as $follower){
            DB::table('unread_notification')->insert(['action' => 'PUBLICATION', 'actionId' => $publicationId, 'userId' => $follower]);
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
            "title"       => $me->name,
            "message"     => "📰 " . $publication->description, //📷🔗📽️
            "notId"       => $me->id,
            "priority"    => 2,
            "icon"        => "notification_small_icon",
            "color"       => "#867446",
            "summaryText" => "%n% publicações novas",
            "style"       => "inbox",
            "userId"      => $me->id,
            "type"        => "publication"
        );
        FCM::notification($muted, $data);
        $data['data']['muted'] = 1;
        FCM::notification($unmuted, $data);
    }
    
}
