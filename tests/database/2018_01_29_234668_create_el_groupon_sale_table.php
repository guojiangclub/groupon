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

class CreateElGrouponSaleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('el_groupon_sale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('groupon_item_id');
            $table->integer('quantity');
            $table->index(['user_id', 'groupon_item_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('el_groupon_sale');
    }
}
