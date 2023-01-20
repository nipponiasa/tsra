<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotosVinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motos_vins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vin')->nullable();
            $table->string('model_desc')->nullable();
            $table->string('po')->nullable();
            $table->string('color')->nullable();
            $table->string('speed')->nullable();
            $table->string('year')->nullable();
            $table->string('country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motos_vins');
    }
}
