<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsCat extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //是否删除，1-是 0-否 默认 0
    const IS_DEL_YES = 1;
    const IS_DEL_NO  = 0;

}
