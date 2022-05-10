<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnduserPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enduser_posts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('enduser_id')->nullable(false);
            $table->string('post_image_id')->nullable(false);
            $table->text('body')->nullable(false);
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
        Schema::dropIfExists('enduser_posts');
    }
}
