<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_notifications', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->integer('enduser_id');
            $table->integer('store_id');
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
        Schema::dropIfExists('public_notifications');
    }
}
