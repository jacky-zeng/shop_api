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