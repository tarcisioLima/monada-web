<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\LinkHelper;

class PublicationBuilder extends Model
{
    
    public static function toFeed($publication){
        $publication->author     = self::buildAuthor($publication);
        $publication->images     = self::getImage($publication->id);
        $publication->categories = self::getCategory($publication->id);
        $publication->link       = self::buildLink($publication->link);
        unset($publication->userId,$publication->authorId, $publication->name, $publication->username, $publication->image);
        return $publication;
    }
    
    public static function buildAuthor($publication){
        return (object)array(
            'userId'   => $publication->userId,
            'authorId' => $publication->authorId,
            'name'     => $publication->name,
            'username' => $publication->username,
            'image'    => $publication->image
        );
    }
    
    public static function getImage($id){
        return DB::table('image')->where('publicationId', $id)->get(['name', 'id']);
    }
    
    public static function getCategory($id){
        return DB::table('publication_category')
            ->join('category', 'publication_category.categoryId', '=', 'category.id')
            ->where('publicationId', $id)->get(['name', 'id']);
    }
    
    public static function buildLink($link){
        if(empty($link))                               return (object)array();
        if($youtube = LinkHelper::isYoutube($link))    return $youtube;
        if($vimeo   = LinkHelper::isVimeo($link))      return $vimeo; 
        $tags       = LinkHelper::getMetaTagOG($link);
        return array(
            "url"   => $link,
            "title" => $tags['title'] ?? null,
            "description" => $tags['description'] ?? null,
            "image" => $tags['image'] ?? null
        );
    }
    
}
