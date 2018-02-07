<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单表orders
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->comment('主键id');
            $table->string('order_number', 30)->index()->comment('订单编号');
            $table->string('out_number', 50)->nullable()->comment('订单编号，外部支付时使用，有些外部支付系统要求特定的订单编号');
            $table->unsignedInteger('user_id')->index()->comment('用户UID');
            $table->unsignedInteger('merchant_id')->index()->comment('商家店铺id');
            $table->decimal("total_amount", 18, 2)->comment('订单总价格(单位元)');
            $table->decimal("order_amount", 18, 2)->comment('需要支付的订单金额(单位元)');
            $table->decimal("send_amount", 18, 2)->default(0)->comment('配送费(单位元)');
            $table->tinyInteger('pay_type')->index()->comment('支付方式类型（1-支付宝 2-微信）');
            $table->tinyInteger('order_status')->index()->default(1)->comment('订单状态：1(默认):待支付 2:待配送 3:已配送 4:已送达(已完成) 5:用户已取消订单 6:商家取消订单 7:系统自动取消 8:后台取消');
            $table->tinyInteger('pay_status')->index()->default(1)->comment('付款状态：0(默认):未付款;1:已付款;');
            $table->tinyInteger('refund_status')->default(1)->comment('退款状态 0未退款 1退款中 2已退款');
            $table->string('order_message')->nullable()->comment('订单留言');
            $table->tinyInteger('settlement_status')->default(1)->comment('结算状态 0未结算 1已结算');
            $table->string('name', 50)->comment('姓名');
            $table->unsignedTinyInteger('sex')->comment('性别：0:未知  1:男  2:女');
            $table->string('mobile', 20)->comment('电话');
            $table->unsignedTinyInteger('tag')->default(0)->comment('标签: 0:未知 1:家  2:公司  3:学校');
            $table->unsignedInteger('province_id')->comment('省id');
            $table->unsignedInteger('city_id')->comment('市id');
            $table->unsignedInteger('area_id')->comment('区id');
            $table->string('province', 16)->comment('省');
            $table->string('city', 16)->comment('市');
            $table->string('area', 16)->comment('区');
            $table->string('area_info')->comment('地址详情');
            $table->string('house_number', 20)->default('')->comment('门牌号');
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
        Schema::dropIfExists('orders');
    }

}
