<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategorizationToTechnicalCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_cases', function (Blueprint $table) {
            $table->dropColumn(["category_id","subcategory_id"]);
            $table->string("part")->nullable()->after('model');
            $table->string("issue")->nullable()->after('model');;
            $table->string("category")->nullable()->after('model');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_cases', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('model');
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('model');
            $table->dropColumn(['part', 'issue', 'category']);
        });
    }
}
