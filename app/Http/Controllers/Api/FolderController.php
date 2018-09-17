<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Obscure;
use App\Models\Folder;
use App\Http\Requests\StoreFolder;
use App\Http\Requests\UpdateFolder;
use App\Http\Requests\UpdateFolderImage;

class FolderController extends Controller
{
    
    public function show(Request $request, $folderId = 0){
        return response()->json(['msg' => 'Pastas', 'data' => Folder::show($request->auth->authorId, $folderId)]);
    }
    
    public function store(StoreFolder $request){
        $folder = Folder::create(['name' => $request->name, 'authorId' => $request->auth->authorId]);
        if($folder){
            return response()->json(['msg' => "Cadastrada com sucesso", 'data' => Obscure::folder($folder->id)]);
        }else{
            return response()->json(['msg' => "Houve um erro interno ao tentarmos cadastrar sua pasta"]);
        }
    }
    
    public function storeImage(StoreImageFolder $request){
        $filename = Folder::storeImage($request->folderId, $request->auth->userId, $request->monadaImage);
        if($filename){
            return response()->json(['msg' => 'Imagem inserida com sucesso', 'data' => $filename]);
        }else{
            return response()->json(['msg' => 'Não foi possível inserir a imagem da pasta']);
        }
    }
    
    public function update(UpdateFolder $request){
        Folder::updateFolder($request);
        return response()->json(['msg' => 'Pasta atualizada com sucesso', 'data' => true]);
    }
    
    public function delete(Request $request, $folderId){
        if(Folder::deleteFolder($folderId)){
            return response()->json(['msg' => 'Pasta removida com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Houve um erro interno ao tentarmos deletar a pasta']);
        }
    }
    
    
}
