<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Utils\Obscure;
use App\Utils\TransformObscure;
use Illuminate\Support\Facades\Storage;

class Folder extends Model
{
    protected $table = 'folder';
    protected $fillable = ['name', 'authorId'];
    public $timestamps = false;
    
    public static function show($authorId, $folderId = 0){
        $query = DB::table('folder')->where('authorId', $authorId);
        if($folderId){
            $query->where('id', $folderId);
            return TransformObscure::folder($query->first());
        }
        return TransformObscure::folderList($query->get());
    }
    
    public static function storeImage($folderId, $userId, $image){
        $filename = $image->store('img/user/'.Obscure::user($userId).'/folder', 's3');
        if($filename){
            $actualImage = DB::table('folder')->where('id', $folderId)->value('image');
            if($actualImage){
                Storage::disk('s3')->delete($actualImage);
            }
            DB::table('folder')->where('id', $folderId)->update(['image' => $filename]);
            return $filename;
        }
        return false;
    }
    
    public static function updateFolder($data){
        $folder = [
            'name' => $data->name,
        ];
        if(!empty($data->removeImage)){
            $folder['image'] = NULL;
            $actualImage = DB::table('folder')->where('id', $data->folderId)->value('image');
            if($actualImage){
                Storage::disk('s3')->delete(DB::table('folder')->where('id', $data->folderId)->value('image'));
            }
        }
        DB::table('folder')->where('id', $data->folderId)->update($folder);
        return true;
    }
    
    public static function deleteFolder($folderId){
        DB::table('publication')->where('folderId', $folderId)->update(['folderId' => NULL]);
        if(DB::table('folder')->where('id', $folderId)->delete()){
            return true;
        }
        return false;
    }
}
