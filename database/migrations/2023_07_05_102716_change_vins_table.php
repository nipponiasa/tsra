<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("vin_to_cases","vins");
        Schema::table("vins", function (Blueprint $table) {
            $table->renameColumn("distancekm","distance");
            $table->renameColumn("case","case_id");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("vins", function (Blueprint $table) {
            $table->renameColumn("distance", "distancekm");
            $table->renameColumn("case_id", "case");
        });
    
        Schema::rename("vins", "vin_to_cases");
    }
}
