<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //商品表
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id')->index()->comment('商家id');
            $table->unsignedInteger('goods_category_id')->index()->comment('商品分类id');
            $table->string('name', 64)->comment('商品名称');
            $table->string('goods_image')->default('')->comment('商品图片');
            $table->tinyInteger('is_sku')->default(0)->comment('是否有规格 1-有 0-没有，默认 0');
            $table->string('sku_detail')->nullable()->comment('规格详情，json格式 json_encode');
            $table->string('description')->default('')->comment('商品描述');
            $table->string('unit', 10)->default('')->comment('单位');
            $table->unsignedInteger('sales_count')->default(0)->comment('总销售数量');
            $table->unsignedInteger('sales_count_month')->default(0)->comment('月销售数量');
            $table->tinyInteger('shelves_status')->default(1)->comment('上架状态 1-上架 0-下架 默认 1（后台管理）');
            $table->tinyInteger('sale_status')->default(1)->comment('售卖状态 1-在售 0-停售 默认 1（商家管理）');
            $table->tinyInteger('is_del')->default(0)->index()->comment('是否删除，1-是 0-否 默认 0');
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
        Schema::dropIfExists('goods');
    }

}
