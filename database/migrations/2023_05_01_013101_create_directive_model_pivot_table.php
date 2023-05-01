<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectiveModelPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change models table engine to InnoDB (prerequisite for foreign keys)
        Schema::table('models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
        });

        // create directive_model pivot table
        Schema::create('directive_model', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('directive_id');
            $table->unsignedBigInteger('model_id');

            $table->foreign('directive_id')->references('id')->on('technical_directives')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directive_model');
    }
}
