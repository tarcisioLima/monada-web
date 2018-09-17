<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\User;
use App\Models\Notification;
use App\Models\Author;
use App\Http\Requests\StorePublication;
use App\Http\Requests\StoreImagePublication;
use App\Http\Requests\SearchPublication;
use App\Http\Requests\UpdatePublication;
use App\Utils\LinkHelper;
use App\Utils\Obscure;
use App\Utils\Scraper;
use App\Builder\PushBuilder;

class PublicationController extends Controller
{
    public function store(StorePublication $request){
        $request->merge(['authorId' => $request->auth->authorId]);
        if(!empty($request->link)){
            $request->merge(['linkId' => Publication::addLink($request->link)]);
        }
        $publication = Publication::create($request->all());
        if($publication){
            Publication::addCategory($request->category ? $request->category : [], $publication->id);
            Publication::addImages($request->images ? $request->images : [], $publication->id);
            $followers = Author::followers($this->authId($request));
            Notification::addUnreadPublication($followers, $request->auth->authorId);
            PushBuilder::publication($request->auth, $followers, $publication);
            return response()->json([
                "msg"  => "Publicação cadastrada com sucesso.", 
                "data" => [
                    "id"   => Obscure::publication($publication->id),
                    "link" => env('APP_URL')
                ]]);
        }else{
            return response()->json(['msg' => "Houve um erro ao cadastrar a publicação. Tente novamente"]);
        }
    }
    
    public function storeOlavo(Request $request){
        $data = Scraper::olavo();
        foreach($data->publications as $dataPublication){
            $publication = Publication::create((array)$dataPublication);
            if($publication){
                $followers = Author::followers($data->auth->userId);
                Notification::addUnreadPublication($followers, $data->auth->authorId);
                PushBuilder::publication($data->auth, $followers, $publication);
                DB::table('scraper')->where('userId', $data->auth->userId)->update(['lastId' => $dataPublication->id]);
            }
        }
        return response()->json(["msg"  => "Publicações do Olavo de Carvalho cadastradas", "data" => $data->publications]);
    }
    
    public function storeImage(StoreImagePublication $request){
        $data = Publication::storeImage($request->auth->userId, $request->monadaImage);
        if($data){
            return response()->json(['msg' => 'Imagem inserida com sucesso', 'data' => $data]);
        }else{
            return response()->json(['msg' => 'Não foi possível inserir a imagem da pasta']);
        }
    }
    
    public function update(UpdatePublication $request){
        Publication::updatePublication($request);
        return response()->json(['msg' => 'Publicação atualizada com sucesso', 'data' => true]);
    }
    
    public function delete(Request $request, $publicationId){
        if(Publication::deletePublication($request->auth->authorId, $publicationId)){
            return response()->json(['msg' => 'Publicação removida com sucesso', 'data' => true]);
        }else{
            return response()->json(['msg' => 'Houve um erro interno ao tentarmos deletar a publicação']);
        }
    }
    
    public function show(Request $request, $offset = 0, $last = 0){
        $publication = Publication::byFollowing($this->authId($request), $offset, $last);
        return response()->json(['msg' => "Publicações", 'data' => $publication]);
    }
    
    public function highlights(Request $request, $offset = 0){
        $publication = Publication::highlights($this->authId($request), $offset);
        return response()->json(['msg' => "Publicações em destaque", 'data' => $publication]);
    }
    
    public function search(SearchPublication $request, $offset = 0){
        $publication = Publication::search($this->authId($request), $request->term, $request->author, $request->category, $request->since, $request->until, $offset, $request->folderId, $request->authorId);
        return response()->json(['msg' => "Publicações pesquisadas", 'data' => $publication]);
    }
    
    public function categories(Request $request){
        return response()->json(['msg' => "Categorias", 'data' => Publication::categories()]);
    }
    
    public function linkMetatag(Request $request){
        $data = array('url' => $request->link);
        if($youtube = LinkHelper::isYoutube($request->link)){
            $data['youtube'] = LinkHelper::embedYoutube($youtube);
        }else if($vimeo   = LinkHelper::isVimeo($request->link)){
            $data['vimeo'] = LinkHelper::embedVimeo($vimeo);
        }else{
            $tags = LinkHelper::getMetaTagOG($request->link);
            $data['title'] = isset($tags['title']) ? substr($tags['title'], 0, 191) : null;
            $data['description'] = isset($tags['description']) ? substr($tags['description'], 0, 191) : null;
            $data['image'] = isset($tags['image']) ? substr($tags['image'], 0, 191) : null;
        }
        return response()->json(['msg' => "Metatags do link", 'data' => $data]);
    }
    
    private function authId($request){
        return $request->auth->userId ?? 0;
    }
    
}
