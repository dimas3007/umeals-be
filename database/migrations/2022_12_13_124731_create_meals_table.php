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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('with');
            $table->string('foto', 2048)->nullable();
            $table->string('description', 2048);
            $table->string('tags');
            $table->string('allergens');
            $table->string('allergens_description', 2048);
            $table->string('total_time');
            $table->string('prep_time');
            $table->string('difficulty');
            $table->integer('price');
            $table->foreignId('nutrition_value_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('meals');
    }
};
