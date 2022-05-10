<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('order_id')->nullable(false);
            $table->integer('store_order_id')->nullable(false);
            $table->integer('item_id')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->integer('price_after_tax')->nullable(false);
            $table->integer('product_status')->default(0);
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
        Schema::dropIfExists('order_items');
    }
}
