<?php

namespace App\Model;


class User extends BaseModel
{
    protected $guarded = ['state'];
    protected $hidden = ['state', 'password'];
}
