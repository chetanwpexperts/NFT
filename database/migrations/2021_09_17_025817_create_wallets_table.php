<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('payment_id');
            $table->float('wallet_amount', 8, 2);
            $table->enum('paymentThrough', ['auction', 'offer', 'razorpay']);
            $table->string('paymentFrom');
            $table->string('payment_type');
            $table->enum('status', ['hold', 'nill', 'active']);
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
        Schema::dropIfExists('wallets');
    }
}
