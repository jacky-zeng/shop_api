<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //地址区域级别
    const DEPTH_FIRST   = 1;   //省级
    const DEPTH_SECOND  = 2;   //市级
    const DEPTH_THIRD   = 3;   //区级

}
