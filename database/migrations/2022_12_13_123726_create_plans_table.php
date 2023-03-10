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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('preference');
            $table->integer('number_of_people');
            $table->integer('receipe_per_week');
            $table->integer('price_per_servings');
            $table->integer('total_price');
            $table->integer('shipping');
            $table->integer('tax');
            $table->date('first_delivery_date');
            $table->string('special_instructions', 2048);
            $table->string('payment_method');
            $table->string('status');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('address_id')->constrained();
            $table->string('payment_status');
            $table->integer('discount');
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
        Schema::dropIfExists('plans');
    }
};
