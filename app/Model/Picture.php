<?php

namespace App\Model;

class Picture extends BaseModel
{
    protected $guarded=['state'];
    protected $hidden=['state'];

    public function uploader() {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function article() {
        return $this->belongsTo('App\Model\Article', 'article_id', 'id');
    }

    public function scopeActive($query) {
        return $query->where('state', '>',0);
    }

    public function scopeTrash($query) {
        return $query->where('state', '<',0);
    }
}
