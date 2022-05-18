<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('email')->nullable(false)->unique();
            $table->string('password')->nullable(false)->unique();
            $table->string('name')->nullable(false);
            $table->string('name_kana')->nullable(false);
            $table->text('introduction')->nullable();
            $table->string('profile_image')->nullable();
            $table->string("image_path")->nullable();
            $table->string('post_address')->nullable(false);
            $table->string('address')->nullable(false);
            $table->string('phone_number')->nullable(false);
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('stores');
    }
}
