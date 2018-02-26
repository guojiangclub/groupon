<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElGrouponSaleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('el_groupon_sale');
    }

}
