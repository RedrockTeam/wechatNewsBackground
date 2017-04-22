<?php

namespace App\Http\Controllers;

use App\Model\Article;
use App\Model\Picture;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ArticleController extends Controller
{

    public function upload(Request $request){
        $user = $request->session()->get('user');
        if(empty($user))    return response()->json(['state'=>403, 'status'=>403, 'info'=>'未登录'], 403);
        $this->validate($request, [
            'title' => 'required|min:1|max:255',
            'content' => 'min:1|max:255',
            'type'  => 'required',
            'target_url' => 'active_url|required',
            'pictureUrl' => 'active_url',
            'uploadPicture' => 'file|image|max:4096'
        ]);

        if ($request->has('pictureUrl')) {
            $pictureInfo = $this->processWebPicture($request->input('pictureUrl'));
        } elseif ($request->hasFile('uploadPicture'))
            $pictureInfo = $this->processUploadPicture($request->file('uploadPicture'));
        else {
            return \Redirect::action('IndexController@show')->withErrors('uploadError');
        }
        $pictureInfo['user_id'] = $user['id'];
        $article = $request->only(['title','type', 'content', 'target_url']);
        $article['user_id'] = $user['id'];
        $article['type_id'] = array_search($article['type'],Article::getArticleType());
        unset($article['type']);
        $article = Article::create($article);
        $pictureInfo['article_id'] = $article['id'];
        Picture::create($pictureInfo);
        return \Redirect::action('IndexController@show');
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file 上传的图片
     * @return boolean|array
     */
    protected function processUploadPicture(\Illuminate\Http\UploadedFile $file){
        $mimeType = $file->getmimeType();
        if(false === $pos = strpos($mimeType, '/'))
            return false;
        $ext = substr($mimeType,$pos+1);
        $fileName = time().'-'.str_random(8).'.'.$ext;
        \Storage::disk('photo')->putFileAs('', $file, $fileName);
        $this->makeThumbnail($fileName);
        $thumbnail = $this->makeThumbnail($fileName);
        $fileName = \URL::route('showPicture',['name'=>$fileName]);
        $thumbnail = \URL::route('showPicture', ['name'=>$thumbnail]);
        return ['photo_src' => $fileName, 'thumbnail_src' => $thumbnail];
    }
    protected function processWebPicture($url) {
        $client = new Client(['verify' => false]);
        try {
            $res = $client->request('Get', $url);
        } catch (GuzzleException $e) {
            return false;
        }

        $contentType = $res->getHeaderLine('content-type');
        if(false === $pos = strpos($contentType, '/'))
            return false;
        $type = substr($contentType, 0, $pos);
        //根据content-type 获取文件的类型
        if (strtolower($type) !== 'image')  return false;
        $ext = substr($contentType, $pos+1);
        $name = function ($n) {
            $basename='123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
            $name = '';
            for($i=0;$i<$n;$i++)
                $name .= $basename[rand(0,58)];
            return $name;
        };
        $fileName = time().'-'.$name(8).'.'.$ext;
        $data = $res->getBody();
        \Storage::disk('photo')->put($fileName, $data->getContents());
        $thumbnail = in_array($ext,['png','jpeg','gif']) ? $this->makeThumbnail($fileName)  : $fileName;
        $fileName = \URL::route('showPicture',['name'=>$fileName]);
        $thumbnail = \URL::route('showPicture', ['name'=>$thumbnail]);
        return ['photo_src' => $fileName, 'thumbnail_src' => $thumbnail];
    }

    protected function makeThumbnail($fileName) {
        $photo = \Storage::disk('photo')->url($fileName);
        $photo = \Image::make($photo);
        $pos = strrpos($fileName, '.');
        $ext = substr($fileName, $pos);
        $name = function ($n) {
            $basename='123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
            $name = '';
            for($i=0;$i<$n;$i++)
                $name .= $basename[rand(0,58)];
            return $name;
        };
        $fileName = time().'-'.$name(8).$ext;
        $width = $photo->width()> 240 ? 240 : $photo->width()*0.8;
        $height = $photo->height()/$photo->width()*$width;
        \Storage::disk('photo')->put($fileName, $photo->resize($width, $height)->stream('png', 60)->getContents());
        return $fileName;
    }

    public function show(Request $request) {
        $type = empty($request->route('type')) ? $request->get('type') : $request->route('type');
        $type_id = array_search($type, Article::getArticleType(),true);
        if($type_id === false)  return response()->json(['status' => 404, 'state' => '404', 'info' => '错误文章类型']);
        $page = $request->get('page', 1);
        if ((int)$type_id === 0)
            $size = $request->get('size', 3);
        else
            $size = $request->get('size',5);

        $articles =  Article::active()
            ->articleTypeId($type_id)
            ->orderBy('updated_at','desc')
            ->select('id','title','target_url', 'created_at', 'updated_at', 'type_id', 'content')
            ->withOnly('pictures', ['thumbnail_src', 'article_id','photo_src', 'id'], ['state','>',0])
            ->get();
        $totalArticleNum = $articles->count();
        $totalPageNum = $totalArticleNum % $size ? $totalArticleNum/$size + 1 : $totalArticleNum/$size;
        $articles = $articles->forPage($page, $size);
        $articles = $articles->values();
        $articles->map(function ($item) {
            $item->pictures->map(function ($picture){
                unset($picture['article_id']);
            });
            $item['type'] = Article::getArticleType()[$item['type_id']];
            unset($item['type_id']);
        });
        $data = [
            'state' => 200,
            'status' => 200,
            'info' => 'success',
            'totalPageNum' => (int)$totalPageNum,
            'currentPage' => (int)$page,
            'totalArticleNum' => $totalArticleNum,
            'data'=> $articles->toArray()
        ];
        return response()->json($data);
    }
    public function edit(Request $request) {
        if (empty(session('user')))     return response()->json(['state'=>403,'status'=>404,'info'=>'未登陆 forbidden'],403);
        $validator = \Validator::make($request->all(),[
            'id'    => 'required|exists:articles,id',
            'title' => 'string|max:255',
            'content' => 'string|max:255',
            'target_url' => 'active_url',
            'pictureUrl' => 'active_url',
            'uploadPicture' => 'file|image|max:4096'
        ]);
        if ($validator->fails()) {
            return response()->json(['state' => 404, 'status' => 404,'info'=>implode($validator->errors()->all(),';')],404);
        }
        if($request->hasFile('uploadPicture') || $request->has('pictureUrl')) {
            if ($request->hasFile('uploadPicture'))
                $info = $this->processUploadPicture($request->file('uploadPicture'));
            else
                $info = $this->processWebPicture($request->get('pictureUrl'));
            if(!$info)   return response()->json(['state' => 404, 'status' => 404,'info'=>'error picture'],404);
           Picture::active()->where('article_id',$request->get('id'))->update(['state'=>0]);
           $info['article_id'] = $request->get('id');
           Picture::create($info);
        }
        $update = $request->except(['id','pictureUrl','uploadPicture']);
        $article=  Article::active()->find($request->get('id'));
        if (!empty($update)) {
            $article =  $article->update($update);
        }
        $article = $article->onlyWith('pictures', ['id','photo_src', 'thumbnail_src'])->get();
        dd($article);
        return \Response::json(['state'=>200,'status'=>200,'info'=>'success','data'=>$article->toArray()]);
    }

    public function editState(Request $request) {
        if (empty(session('user')))     return response()->json(['state'=>403,'status'=>404,'info'=>'未登陆 forbidden'],403);
        $validator = \Validator::make($request->all(),[
            'action' => 'required|string',
            'ids.*'    => 'required|exists:articles,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['state' => 404, 'status' => 404,'info'=>implode($validator->errors()->all(),';')],404);
        }

        $articles = Article::whereIn('id',$request->get('ids'))->get();
        $data = [];
        foreach ($articles as $article) {
            switch ($request->get('action')) {
                case 'delete':
                    if ($article->state <= 0) {
                        return response()->json(['state' => 403, 'status' => 403, 'info' => 'errorState'], 404);
                    }
                    $article->state = -$article->state;
                    break;
                case 'recover':
                    if ($article->state >= 0) {
                        return response()->json(['state' => 403, 'status' => 403, 'info' => 'errorState'], 404);
                    }
                    $article->state = -$article->state;
                    break;
                case 'hot':
                    if ((int)$article->state !== 1) {
                        return response()->json(['state' => 403, 'status' => 403, 'info' => 'errorState'], 404);
                    }
                    $article->state = 2;
                    break;
                case 'unHot':
                    if ((int)$article->state !== 2) {
                        return response()->json(['state' => 403, 'status' => 403, 'info' => 'errorState'], 404);
                    }
                    $article->state = 1;
                    break;
                default:
                    return response()->json(['state' => 403, 'status' => 403, 'info' => 'error action']);
            }
            $article->save();
            $data[] = $article->makeVisible('state')->toArray();
        }

        return response()->json(['state'=>200, 'status'=>200, 'info'=>'success', 'data'=>$data ]);
    }
}
