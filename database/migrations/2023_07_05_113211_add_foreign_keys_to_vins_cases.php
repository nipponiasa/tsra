<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVinsCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("vins", function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->change();
            $table->index('case_id');
            $table->foreign('case_id')->references('id')->on('technical_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vins', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
            $table->dropIndex(['case_id']);
            $table->text('case_id')->change();
        });
    }
}
