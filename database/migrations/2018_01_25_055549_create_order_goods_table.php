<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 订单商品表
        Schema::create('order_goods', function (Blueprint $table) {
            $table->increments('id')->comment('主键id');
            $table->unsignedInteger('order_id')->index()->comment('订单id');
            $table->string('order_number',30)->index()->comment('订单号');
            $table->unsignedInteger('goods_id')->index()->comment('商品id');
            $table->unsignedInteger('product_id')->index()->comment('商品sku_id');
            $table->string('goods_name', 64)->comment('商品名称');
            $table->string('goods_image')->comment('商品图片');
            $table->decimal("price", 18, 2)->default(0)->comment('单价(单位元)');
            $table->unsignedInteger('goods_num')->comment('商品数量');
            $table->string('sku_detail')->nullable()->comment('商品sku明细');
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
        Schema::dropIfExists('order_goods');
    }
}
