<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateElOrderTable extends Migration
{
    /**
     * Run the migrations.
     */

    const STATUS_TEMP = 0;   //临时订单
    const STATUS_NEW = 1;    //有效订单，待付款
    const STATUS_PAY = 2;    //已支付订单，待发货

    const STATUS_DELIVERED = 3;    //已发货，待收货
    const STATUS_RECEIVED = 4;    //已收货，待评价
    const STATUS_COMPLETE = 5;    //已评价，订单完成

    const TYPE_DEFAULT = 0;//默认类型
    const TYPE_GROUPON = 8;//拼团订单


    public function up()
    {
        Schema::create('el_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no');
            $table->integer('type');
            $table->integer('status')->default(0);
            $table->string('completion_time')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('el_order');
    }
}
