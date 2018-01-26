<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //商品分类表（商家页左侧列表）
        Schema::create('goods_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id')->index()->comment('商家id');
            $table->string('name', 20)->comment('分类名称');
            $table->unsignedInteger('sort')->default(0)->comment('排序，越大越靠前');
            $table->tinyInteger('is_del')->default(0)->comment('是否删除：1 是、0 否');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_cats');
    }

}
