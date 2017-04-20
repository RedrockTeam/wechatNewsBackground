<?php

namespace App\Model;


class User extends BaseModel
{
    protected $guarded = ['state'];
    protected $hidden = ['state', 'password'];

    public function pictures() {
        return $this->hasMany('App\Model\Picture', 'user_id', 'id');
    }
    public function articles() {
        return $this->hasMany('App\Model\Article', 'user_id', 'id');
    }
}
