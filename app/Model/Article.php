<?php

namespace App\Model;


class Article extends BaseModel
{
    protected $guarded=['state'];
    protected static $articleType = [
         'hotArticle', 'studyMaterial', 'news', 'online'
    ];
    protected static $articleTypeShow = ['热门文章','学习资料', '基层动态', '线上互动'];
    protected $hidden = [];
    protected static $actions = ['delete','recover', 'hot', 'unHot'];

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
        return $query->where('state', '<', 0);
    }


    public function scopeArticleType($query, $type) {
        $type_id = array_search($type, Article::getArticleType(),true);
        if ($type_id === false) return false;

        return $this->scopeArticleTypeId($query, $type_id);
    }

    public function scopeArticleTypeId($query,$type_id) {
        if ((int)$type_id === 0)
            $query->where("state",  '2');
        else
            $query->where("type_id", $type_id);
        return $query;
    }

    public static function getArticleType() {
        return self::$articleType;
    }
    public static function getArticleTypeShow() {
        return self::$articleTypeShow;
    }
    public static function getActions() {
        return self::$actions;
    }
}
