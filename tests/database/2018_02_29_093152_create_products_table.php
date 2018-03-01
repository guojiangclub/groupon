<?php

/*
 * This file is part of ibrand/groupon.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     * 货品表
     * @return void
     */
    public function up()
    {
        Schema::create('el_goods_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id');    //商品ID
            $table->integer('store_nums')->default(0);  //库存
            $table->string('sku')->nullable();    //sku
            $table->decimal('sell_price',15,2); //销售价格
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
        Schema::drop('el_goods_product');
    }
}

