<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('country_id')->nullable()->after('updated_at');
        });
        Schema::table('technical_cases', function (Blueprint $table) {
            $table->bigInteger('country_id')->nullable()->after('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
    
        Schema::table('technical_cases', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
    }
}
