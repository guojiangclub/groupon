<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElGrouponItemTable extends Migration
{
    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('el_groupon_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('groupon_id');
            $table->integer('goods_id');     //商品ID
            $table->integer('number');  //成团人数
            $table->integer('max_number')->nullable()->default(0);  //最大成团人数
            $table->decimal('groupon_price',15,2);  //团购价格
            $table->tinyInteger('status')->default(0); //参与状态：0 不参与；1 参与
            $table->integer('limit')->default(0);    //限购数量：0 不限购；
            $table->tinyInteger('get_point')->default(0); //是否可获得积分：0 否；1是
            $table->tinyInteger('use_point')->default(0); //是否可使用积分：0 否；1是
            $table->integer('rate')->default(0);    //佣金比例
            $table->integer('sort')->default(9);    //排序
            $table->string('img')->nullable();  //广告图
            $table->integer('sell_num')->default(0);    //销量
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
        Schema::drop('el_groupon_item');
    }

}
