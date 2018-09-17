<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use DOMDocument;
use Illuminate\Support\Facades\DB;

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
            return $youtube[1];
        }
        return false;
    }
    
    public static function isVimeo($link){
        if(preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $link, $vimeo)){
            return $vimeo[3];
        }
        return false;
    }
    
    public static function embedYoutube($id){
        return "https://www.youtube.com/embed/" . $id;
    }
    
    public static function embedVimeo($id){
        return "https://player.vimeo.com/video/" . $id;
    }
    
    public static function linkToStore($link){
        $data = ['url' => $link, 'youtube' => NULL, 'vimeo' => NULL, 'title' => NULL, 'description' => NULL, 'image' => NULL];
        if($youtube = LinkHelper::isYoutube($link)){
            $data['youtube'] = $youtube;
        }else if($vimeo   = LinkHelper::isVimeo($link)){
            $data['vimeo'] = $vimeo;
        }else{
            $tags = LinkHelper::getMetaTagOG($link);
            $data['title'] = isset($tags['title']) ? substr($tags['title'], 0, 191) : null;
            $data['description'] = isset($tags['description']) ? substr($tags['description'], 0, 191) : null;
            $data['image'] = isset($tags['image']) ? substr($tags['image'], 0, 191) : null;
        }
        return $data;
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
