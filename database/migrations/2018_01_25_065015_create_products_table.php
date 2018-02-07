<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品规格表
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id')->index()->comment('商品id');
            $table->unsignedInteger('merchant_id')->index()->comment('商家id');
            $table->unsignedInteger('goods_category_id')->index()->comment('商品分类id');
            $table->string('sku_name', 20)->comment('规格名称');
            $table->decimal('price', 18, 2)->default(0)->comment('商品单格,单位元');
            $table->unsignedInteger('stocks')->default(1)->comment('商品库存');
            $table->tinyInteger('shelves_status')->default(1)->comment('(与goods表保持同步)上架状态 1-上架 0-下架 默认 1（后台管理）');
            $table->tinyInteger('sale_status')->default(1)->comment('(与goods表保持同步)售卖状态 1-在售 0-停售 默认 1（商家管理）');
            $table->tinyInteger('is_del')->default(0)->index()->comment('(与goods表保持同步)是否删除，1-是 0-否 默认 0');
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
        Schema::dropIfExists('products');
    }

}