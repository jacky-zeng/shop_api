<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 经营类目表
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->comment('名称');
            $table->string('image')->comment('图片');
            $table->unsignedInteger('sort')->default(0)->comment('排序，值越小越靠前，默认 0');
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
        Schema::dropIfExists('categories');
    }

}
