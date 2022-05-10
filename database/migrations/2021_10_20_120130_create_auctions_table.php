<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('owner_id');
            $table->string('nftid');
            $table->float('bid_amount', 8, 2);
            $table->float('amount_paid', 8, 2);
            $table->float('amount_pending', 8, 2);
            $table->enum('status', ['sold', 'not sold', 'in auction']);
            $table->enum('offer_status', ['accepted', 'rejected']);
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
        Schema::dropIfExists('auctions');
    }
}
