<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElGrouponTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('el_groupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');    //活动标题
            $table->tinyInteger('status')->default(1); //状态：0 无效；1有效            
            $table->integer('auto_close')->default(0);    //拍下多少分钟未付款自动关闭订单：0 采用商城统一设置；>0 使用单独设置
            $table->dateTime('starts_at');    //开始时间
            $table->dateTime('ends_at');    //结束时间
            $table->string('tags')->nullable(); //活动标签            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('el_groupon');
    }

}
