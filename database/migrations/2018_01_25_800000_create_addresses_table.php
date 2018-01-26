<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //收获地址表
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->comment('用户ID');
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
        Schema::dropIfExists('addresses');
    }

}
