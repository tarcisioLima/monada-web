<?php

namespace App\Utils;

use Hashids\Hashids;

class Obscure
{
    public static function user($id)
    {
        $hash = new Hashids(env('HASHIDS_SALT_USER'), 10);
        return $hash->encode($id);
    }
    
    public static function author($id)
    {
        $hash = new Hashids(env('HASHIDS_SALT_AUTHOR'), 10);
        return $hash->encode($id);
    }
    
    public static function publication($id)
    {
        $hash = new Hashids(env('HASHIDS_SALT_PUBLICATION'), 15);
        return $hash->encode($id);
    }
    
    public static function folder($id)
    {
        $hash = new Hashids(env('HASHIDS_SALT_FOLDER'), 10);
        return $hash->encode($id);
    }
    
    public static function image($id)
    {
        $hash = new Hashids(env('HASHIDS_SALT_IMAGE'), 15);
        return $hash->encode($id);
    }
    
    public static function unuser($id)
    {
        return self::decode(new Hashids(env('HASHIDS_SALT_USER'), 10), $id);
    }
    
    public static function unauthor($id)
    {
        return self::decode(new Hashids(env('HASHIDS_SALT_AUTHOR'), 10), $id);
    }
    
    public static function unpublication($id)
    {
        return self::decode(new Hashids(env('HASHIDS_SALT_PUBLICATION'), 15), $id);
    }
    
    public static function unfolder($id)
    {
        return self::decode(new Hashids(env('HASHIDS_SALT_FOLDER'), 10), $id);
    }
    
    public static function unimage($id)
    {
        return self::decode(new Hashids(env('HASHIDS_SALT_IMAGE'), 15), $id);
    }
    
    private static function decode($hash, $id){
        if($id == '0')
            return 0;
        if(ctype_digit($id))
            return null;
        return isset($hash->decode($id)[0]) ? $hash->decode($id)[0] : null;
    }

}