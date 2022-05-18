<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id')->nullable(false);
            $table->integer('postage')->nullable(false);
            $table->integer('total_price')->nullable(false);
            $table->integer('pay_method')->default(0);
            $table->string('post_address')->nullable(false);
            $table->string('address')->nullable(false);
            $table->string('name')->nullable(false);
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
        Schema::dropIfExists('orders');
    }
}
