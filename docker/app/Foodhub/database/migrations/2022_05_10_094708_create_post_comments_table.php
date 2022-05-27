<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id')->nullable(true);
            $table->integer('store_id')->nullable(true);
            $table->integer('user_post_id')->nullable(true);
            $table->integer('store_post_id')->nullable(true);
            $table->text('comment')->nullable(false);
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
        Schema::dropIfExists('post_comments');
    }
}
