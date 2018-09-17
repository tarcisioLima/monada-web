<?php

namespace App\Builder;

use Illuminate\Support\Facades\DB;
use App\Utils\FCM;
use App\Utils\NotificationBuilder;
use App\Utils\ActionEnum;

class PushBuilder{
    
    public static function publication($me, $followers, $publication){
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
            "notId"         => $me->userId,
            "priority"      => 2,
            "summaryText"   => "%n% publicações novas",
            "style"         => "inbox",
            "authorId"      => $me->authorId,
            "publicationId" => $publication->id,
            "type"          => ActionEnum::PUBLICATION
        );
        FCM::notification($unmuted, $data);
        
        unset($data['title'], $data['message']);
        FCM::notification($muted, $data);
    }
    
    public static function relation($me, $user){
        $data = array(
            "title"         => $me->auth->username . " seguiu você",
            "message"       => "Agora o ". $me->auth->name . " receberá suas publicações",
            "type"          => ActionEnum::RELATION,
            "image"         => ENV('AWS_IMAGE_URL') . $me->auth->image,
            "image-type"    => "circle",
            "notId"         => -100
        );
        FCM::notification(self::getFcm($user), $data);
    }
    
    public static function like($me, $user){
        $data = array(
            "title"         => "Nova curtida!",
            "message"       => $me->auth->username . " curtiu sua publicação",
            "type"          => ActionEnum::LIKE,
            "image"         => ENV('AWS_IMAGE_URL') . $me->auth->image,
            "image-type"    => "circle",
            "notId"         => -200
        );
        FCM::notification(self::getFcm($user), $data);
    }
    
    public static function system($title, $description, $image){
        $data = array(
            "title"         => $title,
            "message"       => $description,
            "type"          => ActionEnum::SYSTEM,
            "style"         => "picture",
            "picture"       => $image,
            "notId"         => -300
        );
        FCM::notification(self::getFcm(), $data);
    }

    private static function getFcm($userId = null){
        if($userId){
            return DB::table('device')->where('userId', $userId)->whereNotNull('fcm')->pluck('fcm')->toArray();
        }
        return DB::table('device')->whereNotNull('fcm')->pluck('fcm')->toArray();
    }
    
}
