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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('creator_id')->unique();
            $table->string('owner_id');
            $table->string('user_type');
            $table->string('video');
            $table->string('social_media_accounts');
            $table->string('signature');
            $table->string('phone');
            $table->string('about');
            $table->string('dp');
            $table->date('dob');
            $table->string('marital_status');
            $table->string('gender');
            $table->integer('status');
            $table->enum('badges', ['gold', 'purple']);
            $table->integer('otp');
            $table->integer('email_otp');
            $table->rememberToken();
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
