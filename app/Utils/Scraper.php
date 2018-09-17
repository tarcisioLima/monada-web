<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Goutte;
use App\Utils\LinkHelper;
use App\Models\Publication;

class Scraper{
    
    public static function olavo(){
        $user = DB::table('scraper')
            ->join('user', 'scraper.userId', "=", "user.id")
            ->join('author', 'user.id', "=", "author.userId")
            ->where('scraper.userId', 25)
            ->first(['lastId', 'user.id AS userId', 'author.id AS authorId', 'image', 'username', 'name']);
        
        $publications = array();
        $number = 1;
        while(true){
            $data = self::crawler($number);
            if(empty($data)) break;
            foreach($data as $publication){
                if($publication->id <= $user->lastId) break;
                $publication->description = implode("\n", $publication->description);
                if(!empty($publication->folder)){
                    $publication->folderId = DB::table('folder')->where('name', $publication->folder)->where('authorId', $user->authorId)->value('id');
                    if(empty($publication->folderId)){
                        $publication->folderId = DB::table('folder')->insertGetId(['name' => $publication->folder, 'authorId' => $user->authorId]);
                    }
                    if($youtube = LinkHelper::isYoutube($publication->videoLink)){
                        $publication->linkId = Publication::addLink("https://www.youtube.com/watch?v=" . $youtube);
                    }
                }
                $publication->authorId = $user->authorId;
                $publications[] = $publication;
            }
            $number++;
        }
        
        return (object)array(
            'auth'         => $user,
            'publications' => array_reverse($publications)
        );
    }
    
    private static function crawler($number){
        $crawler = Goutte::request('GET', 'https://blogdoolavo.com/author/olavodecarvalho/page/'. $number);
        $publications = $crawler->filter('.site-main article')->each(function ($node){
            $id = intval(preg_replace('/[^0-9]+/', '', $node->attr('id')));
            if($node->filter('.entry-header h1 a')->count() > 0){
                $title = $node->filter('.entry-header h1 a')->text();
                $link = $node->filter('.entry-header h1 a')->attr('href');
            }
            if($node->filter('.entry-content p')->count() > 0){
                $description = $node->filter('.entry-content p')->each(function ($nodeDescription){
                    return $nodeDescription->text();
                });
            }
            if($node->filter('.entry-content iframe')->count() > 0){
                $videoLink = $node->filter('.entry-content iframe')->attr('src');
            }
            if($node->filter('.entry-footer .entry-meta .cat-links a')->count() > 0){
                $folder = $node->filter('.entry-footer .entry-meta .cat-links a')->text();
            }
            return (object)array(
                "id"          => $id ?? null,
                "title"       => $title ?? null,
                "description" => $description ?? [],
                "link"        => $link ?? null,
                "videoLink"   => $videoLink ?? null,
                "folder"   => $folder ?? null,
            );
        });
        return $publications;
    }

}