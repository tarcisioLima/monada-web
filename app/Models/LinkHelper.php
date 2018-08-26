<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DOMDocument;

class LinkHelper extends Model
{
    public static function getMetaTagOG($url){
        $html = self::curlGet($url);
        $doc = new DOMDocument();
        @$doc->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        $tags = $doc->getElementsByTagName('meta');
        $metadata = array();
        foreach ($tags as $tag){
            if ($tag->hasAttribute('property') && strpos($tag->getAttribute('property'), 'og:') === 0) {
                $key = strtr(substr($tag->getAttribute('property'), 3), '-', '_');
                $value = $tag->getAttribute('content');
            }
            if (!empty($key)) {
                $metadata[$key] = $value;
            }
        }
        return $metadata;
    }
    
    public static function isYoutube($link){
        if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $youtube)){
            return array("youtube" => "https://www.youtube.com/embed/" . $youtube[1]);
        }
        return false;
    }
    
    public static function isVimeo($link){
        if(preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $link, $vimeo)){
            return array("vimeo" => "https://player.vimeo.com/video/" . $vimeo[3]);
        }
        return false;
    }

    private static function curlGet($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
}
