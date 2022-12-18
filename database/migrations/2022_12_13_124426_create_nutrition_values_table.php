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
        Schema::create('nutrition_values', function (Blueprint $table) {
            $table->id();
            $table->string('calories');
            $table->string('saturated_fat');
            $table->string('sugar');
            $table->string('protein');
            $table->string('sodium');
            $table->string('fat');
            $table->string('carbohidrates');
            $table->string('dietary_fiber');
            $table->string('colesterol');
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
        Schema::dropIfExists('nutrition_values');
    }
};
