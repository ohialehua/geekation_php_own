<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('store_id')->nullable(false);
            $table->string('image')->nullable(false);
            $table->string('name')->nullable(false);
            $table->text('body')->nullable(false);
            $table->integer('price_before_tax')->nullable(false);
            $table->integer('sales_figures')->default(0);
            $table->boolean('is_active')->nullable(false);
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
        Schema::dropIfExists('items');
    }
}
