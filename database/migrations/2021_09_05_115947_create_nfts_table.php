<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfts', function (Blueprint $table) {
            $table->id();
            $table->string('nftid')->unique();
            $table->integer('creator_id');
            $table->integer('owner_id');
            $table->string('title');
            $table->text('file');
            $table->string('category');
            $table->longText('tags');
            $table->dateTime('auction_time');
            $table->dateTime('auction_end_time');
            $table->string('price');
            $table->enum('status', ['draft', 'published']);
            $table->enum('type', ['auction', 'demand', 'draft']);
            $table->enum('is_favourite', ['1', '0']);
            $table->integer('likes');
            $table->integer('views');
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
        Schema::dropIfExists('nfts');
    }
}
