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
            $table->integer('sender_id')->nullable(true);
            $table->integer('receiver_id')->nullable(true);
            $table->integer('user_id')->nullable(true);
            $table->integer('store_id')->nullable(true);
            $table->integer('store_order_id')->nullable(true);
            $table->integer('post_comment_id')->nullable(true);
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
