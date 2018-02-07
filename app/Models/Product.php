<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //关联商品表
    public function goods()
    {
        return $this->belongsTo(Good::class, 'goods_id', 'id');
    }

}
