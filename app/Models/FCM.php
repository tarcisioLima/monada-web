<?php

namespace App\Models;

class FCM{

    public static function notification($token, $data){
        $data["content-available"] = "1";
        foreach(array_chunk($token, 1000) as $tokenChunked){
            $fields = array(
                'registration_ids' => $tokenChunked,
                'data'             => $data,
                "collapse_key"     => "new_messages"
            );
            FCM::send($fields);
        }
    }
    
    
    private static function send($fields){
        $headers = array(
            'Authorization: key='.env('FCM_ID'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch,CURLOPT_POST, true );
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch );
        curl_close( $ch );
        //echo $result . '<br>';
    }
    
}