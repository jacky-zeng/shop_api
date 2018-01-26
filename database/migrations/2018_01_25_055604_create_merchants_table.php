<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //商家信息表
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('name', 32)->comment('商家名');
            $table->unsignedInteger('category_id')->comment('经营类目id');
            $table->string('category_name', 16)->default('')->comment('经营类目');
            $table->string('mobile', 120)->default('')->comment('商户电话，多个以逗号分隔');
            $table->string('business_time')->default('')->comment('营业时间，json格式');
            $table->tinyInteger('business_status')->default(1)->comment('营业状态 1-营业中 2-已打烊');
            $table->string('logo')->default('')->comment('店铺logo');
            $table->string('banner')->default('')->comment('店铺banner');
            $table->string('notice')->default('')->comment('店铺公告');
            $table->unsignedInteger('province_id')->comment('商家所在省id');
            $table->string('province', 16)->default('')->comment('商家所在省');
            $table->unsignedInteger('city_id')->comment('商家所在市id');
            $table->string('city', 16)->default('')->comment('商家所在市');
            $table->unsignedInteger('area_id')->comment('商家所在区id');
            $table->string('area', 16)->default('')->comment('商家所在区');
            $table->string('address')->default('')->comment('商家详细地址');
            $table->unsignedInteger('score')->default(0)->comment('综合评分（星级）');
            $table->unsignedInteger('average_time')->default(60)->comment('平均配送时间，默认60分钟');
            $table->tinyInteger('is_shelves')->default(1)->comment('上下架状态  默认1已上架  0已下架');
            $table->unsignedInteger('fee')->default(0)->comment('配送费 以分为单位');
            $table->unsignedInteger('min_delivery')->default(0)->comment('起送价 以分为单位');
            $table->unsignedInteger('collection_count')->default(0)->comment('总收藏数量');
            $table->unsignedInteger('sales_count')->default(0)->comment('总销售数量');
            $table->unsignedInteger('sales_count_month')->default(0)->comment('月销售数量');
            $table->unsignedInteger('sales_total')->default(0)->comment('总营业额 单位 分');
            $table->unsignedInteger('click_total')->default(0)->comment('点击量');
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
        Schema::dropIfExists('merchants');
    }

}
