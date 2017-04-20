<?php

namespace App\Model;


class Article extends BaseModel
{
    protected $guarded=['state'];
    protected static $articleType = [
         'hotArticle', 'studyMaterial', 'notice','news',
    ];
    protected static $articleTypeShow = ['热门文章','学习资料', '通知公告','基层动态'];
    protected $hidden = [];

    public function pictures() {
        return $this->hasMany('App\Model\Picture', 'article_id', 'id');
    }

    public function author() {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function scopeActive($query) {
        return $query->where('state', '>', 0);
    }

    public function scopeTrash($query) {
        return $query->where('state', 0);
    }


    public function scopeArticleType($query, $type) {
        $type_id = array_search($type, Article::getArticleType(),true);
        if ($type_id === false) return false;
        $query->where("type_id", $type_id);
        return $query;
    }

    public function scopeArticleTypeId($query,$type_id) {
        $query->where("type_id", $type_id);
        return $query;
    }

    public static function getArticleType() {
        return self::$articleType;
    }
    public static function getArticleTypeShow() {
        return self::$articleTypeShow;
    }
}
