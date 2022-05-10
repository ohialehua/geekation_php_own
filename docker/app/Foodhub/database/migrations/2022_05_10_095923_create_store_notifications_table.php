<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_notifications', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('enduser_id')->nullable(false);
            $table->integer('store_id')->nullable(false);
            $table->integer('store_order_id');
            $table->integer('post_id');
            $table->integer('post_comment_id');
            $table->string('action')->nullable(false);
            $table->boolean('checked')->default(false);
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
        Schema::dropIfExists('store_notifications');
    }
}
