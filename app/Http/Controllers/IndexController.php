<?php

namespace App\Http\Controllers;

use App\Model\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function show(Request $request) {
        if (empty(session('user')))
            return redirect()->route('loginPage');
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
            $article['type'] = Article::getArticleTypeShow()[$article['type_id']];
        }
        $articlesNum = Article::groupBy('type_id')->active()->selectRaw('count(id) as article_num, type_id')->get()->pluck('article_num', 'type_id')->all();
        $articlesNum[0] = Article::active()->ArticleTypeId(0)->count();
        $articleTypes = [];
        foreach (Article::getArticleType() as $key => $value) {
            $articleType['value'] =$value;
            $articleType['display'] = Article::getArticleTypeShow()[$key];
            $articleType['article_num'] = isset($articlesNum[$key]) ? $articlesNum[$key] : 0;
            $articleTypes[$key] = $articleType;
        }
        $data = [
            'user'=>session(['user']),
            'articleTypes'=>$articleTypes,
            'articles' => $articles,
            'articleNums' => $articlesNum,
        ];
        return view('home', $data);
    }

    public function logout() {
        if (!empty(session('user')))
            session()->forget('user');
        return redirect()->route('loginPage');
    }
}
