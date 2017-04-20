<?php

namespace App\Http\Controllers;

use App\Model\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function show(Request $request) {
        $user = session('user');
        $articles = Article::active()
            ->select('id','title','target_url', 'created_at', 'updated_at', 'type_id','user_id', 'content','state')
            ->withOnly('pictures', ['thumbnail_src', 'article_id','photo_src', 'id'], ['state','>',0])
            ->withOnly('author', ['id', 'username'], ['state', '>', 0])
            ->get();
        $articles = $articles->toArray();
        foreach ($articles as &$article) {
            $article['author'] = $article['author']['username'];
            foreach ($article['pictures'] as &$picture) {
                unset($picture['article_id']);
            }
            $article['type'] = Article::getArticleType()[$article['type_id']];
            unset($article['type_id']);
        }
        $articleTypes = [];
        foreach (Article::getArticleType() as $key => $value) {
            if ($key === 0)  continue;
            $articleType['value'] =$value;
            $articleType['display'] = Article::getArticleTypeShow()[$key];
            $articleTypes[] = $articleType;
        }
        $data = [
            'user'=>session(['user']),
            'articleTypes'=>$articleTypes,
            'articles' => $articles,
        ];
        return view('home', $data);
    }
}
