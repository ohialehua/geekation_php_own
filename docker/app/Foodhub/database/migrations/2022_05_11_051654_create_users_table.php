<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('password')->nullable(false)->unique();
            $table->string('name')->nullable(false);
            $table->text('introduction')->nullable();
            $table->string('profile_image_id')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('full_name')->nullable(false)->default("");
            $table->string('full_name_kana')->nullable(false)->default("");
            $table->string('phone_number')->nullable(false)->default("");
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
        Schema::dropIfExists('users');
    }
}
