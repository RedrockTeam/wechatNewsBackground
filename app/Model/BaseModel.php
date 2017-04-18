<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeWithOnly($query, $relation, Array $columns =[], Array $restriction = [])
    {
        return $query->with([$relation => function ($query) use ($columns){
            if (!empty($columns))
                $query->select($columns);
            if (!empty($restriction))
                $query->where($restriction);
        }]);
    }
}
