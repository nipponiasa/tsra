<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalDirectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_directives', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('subject')->nullable();
            $table->longText('directive')->nullable();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->string('publish_state')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_directives');
    }
}
