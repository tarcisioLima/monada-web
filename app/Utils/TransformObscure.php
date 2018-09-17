<?php

namespace App\Utils;

use App\Utils\Obscure;

class TransformObscure
{
    
    public static function author($data){
        $data->userId = Obscure::user($data->userId);
        $data->authorId = Obscure::author($data->authorId);
        return $data;
    }
    
    public static function authorList($data){
        return array_map(function($x){
            $x->userId = Obscure::user($x->userId);
            $x->authorId = Obscure::author($x->authorId);
            return $x;
        }, $data->toArray());
    }
    
    public static function user($data){
        $data->userId = Obscure::user($data->userId);
        $data->image  = ENV('AWS_IMAGE_URL') . ($data->image ? $data->image : config('global.default_user_img'));
        return $data;
    }
    
    public static function userList($data){
        return array_map(function($x){
            $x->userId = Obscure::user($x->userId);
            $x->image  = ENV('AWS_IMAGE_URL') . ($x->image ? $x->image : config('global.default_user_img'));
            return $x;
        }, $data->toArray());
    }
    
    public static function folder($data){
        $data->id = Obscure::folder($data->id);
        return $data;
    }
    
    public static function folderList($data){
        return array_map(function($x){
            $x->id       = Obscure::folder($x->id);
            $x->authorId = Obscure::author($x->authorId);
            return $x;
        }, $data->toArray());
    }
    
    public static function imageList($data){
        return array_map(function($x){
            $x->id       = Obscure::image($x->id);
            $x->name     = ENV('AWS_IMAGE_URL') . $x->name;
            return $x;
        }, $data->toArray());
    }
    
}