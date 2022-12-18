<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('meal_id')->constrained();
            $table->foreignId('address_id')->constrained();
            $table->string('payment_status');
            $table->integer('amount');
            $table->integer('shipping');
            $table->integer('tax');
            $table->integer('discount');
            $table->date('first_delivery_date');
            $table->string('special_instructions', 2048);
            $table->integer('total_price');
            $table->string('payment_method');
            $table->string('status');
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
        Schema::dropIfExists('orders');
    }
};
