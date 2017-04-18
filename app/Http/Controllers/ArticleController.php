<?php

namespace App\Http\Controllers;

use App\Model\Article;
use function foo\func;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function upload(Request $request){
        $this->validate($request, [
            'title' => 'required|min:2',
            'type'  => 'required',
            'pictureUrl' => 'url',
            'pictureUpload' => 'required_without:pictureUrl|file|image|max:4096'
        ]);
    }

    public function show(Request $request) {
        $type = empty($request->route('type')) ? $request->get('type') : $request->route('type');
        $type_id = array_search($type, Article::getArticleType(),true);
        if($type_id === false)  return response()->json(['status' => 404, 'state' => '404', 'info' => '错误文章类型']);
        $page = $request->get('page', 1);
        $size = $request->get('size', 5);
        if ($type_id == 0)
            $articles = Article::where('state', '>', 2);
        else
            $articles = Article::active()->articleTypeId($type_id);
        $articles = $articles
            ->orderBy('created_at','desc')
            ->forPage($page, $size)
            ->select('id','title','target_url', 'created_at', 'updated_at', 'type_id')
            ->withOnly('pictures', ['thumbnail_src', 'article_id','photo_src', 'id'], ['state','>',0])
            ->get();
        $articles->map(function ($item) {
            $item->pictures->map(function ($picture){
                unset($picture['article_id']);
            });
            $item['type'] = Article::getArticleType()[$item['type_id']];
            unset($item['type_id']);
        });
        $data = ['state' => 200, 'status' => 200, 'info' => 'success', 'page' => $page,'data'=> $articles->toArray()];
        return response()->json($data);
    }
}
