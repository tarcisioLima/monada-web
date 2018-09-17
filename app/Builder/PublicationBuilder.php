<?php

namespace App\Builder;

use Illuminate\Support\Facades\DB;
use App\Utils\LinkHelper;
use App\Utils\TransformObscure;
use App\Utils\Obscure;

class PublicationBuilder
{
    
    public static function toFeed($publication){
        $publication->author     = self::buildAuthor($publication);
        $publication->images     = self::getImage($publication->id);
        $publication->categories = self::getCategory($publication->id);
        $publication->link       = self::getLink($publication->linkId);
        $publication->folder     = self::getFolder($publication->folderId);
        unset($publication->userId,$publication->authorId, $publication->name, $publication->username, $publication->image, $publication->linkId, $publication->folderId);
        $publication->id         = Obscure::publication($publication->id);
        return $publication;
    }
    
    public static function buildAuthor($publication){
        return TransformObscure::author((object)array(
            'userId'   => $publication->userId,
            'authorId' => $publication->authorId,
            'name'     => $publication->name,
            'username' => $publication->username,
            'image'    => $publication->image
        ));
    }
    
    public static function getFolder($id){
        if(!empty($id)){
            return TransformObscure::folder(DB::table('folder')->where('id', $id)->first(['id', 'name', 'image']));
        }
        return (object)array();
    }
    
    public static function getImage($id){
        return TransformObscure::imageList(DB::table('image')->where('publicationId', $id)->get(['name', 'id']));
    }
    
    public static function getCategory($id){
        return DB::table('publication_category')
            ->join('category', 'publication_category.categoryId', '=', 'category.id')
            ->where('publicationId', $id)->get(['name', 'id']);
    }
    
    public static function getLink($linkId){
        if(!empty($linkId)){
            $link = DB::table('link')->where('id', $linkId)->first();
            if(!empty($link->youtube)){
                return array("youtube" => LinkHelper::embedYoutube($link->youtube), "url" => $link->url);
            }
            if(!empty($link->vimeo)){
                return array("vimeo" => LinkHelper::embedVimeo($link->vimeo), "url" => $link->url);
            }
            return array(
                "url"         => $link->url,
                "title"       => $link->title,
                "description" => $link->description,
                "image"       => $link->image
            );
        }
        return (object)array();
    }
    
}
