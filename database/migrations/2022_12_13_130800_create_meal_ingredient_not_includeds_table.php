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
        Schema::create('meal_ingredient_not_includeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained();
            $table->string('ingredient', 255);
            $table->integer('amount');
            $table->string('unit');
            $table->string('contains');
            $table->string('foto', 2048);
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
        Schema::dropIfExists('meal_ingredient_not_includeds');
    }
};
