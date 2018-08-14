<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Publication extends Model
{
    protected $table    = 'publication';
    protected $fillable = ['title', 'description', 'link', 'draft', 'authorId', 'folderId'];
    public $timestamps = false;
    
    public static function addCategory($category, $publicationId){
        foreach($category as $categoryId){
            DB::table('publication_category')->insert(['categoryId' => $categoryId, 'publicationId' => $publicationId]);
        }
    }
    
    public static function addImages($images, $publicationId){
        foreach($images as $image){
            $filename = APP_ENV('local') ? $image->store('img/publication') : $image->store('img/publication', 's3');
            DB::table('image')->insert(['name' => $filename, 'publicationId' => $publicationId]);
        }
    }
}
