<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectiveCountryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directive_country', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('directive_id');
            $table->unsignedBigInteger('country_id');

            $table->foreign('directive_id')->references('id')->on('technical_directives')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directive_country');
    }
}
