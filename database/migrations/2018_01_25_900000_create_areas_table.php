<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //区域信息表
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('area_code', 10)->index()->comment('区域代码');
            $table->string('name', 16)->comment('名称');
            $table->unsignedInteger('up_id')->index()->comment('父级id');
            $table->unsignedTinyInteger('depth')->index()->comment('区域等级深度');
            $table->unsignedInteger('sort')->default(0)->comment('排序，值越小越靠前');
            $table->string('pinyin', 100)->default('')->comment('拼音');
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
        Schema::dropIfExists('areas');
    }

}
