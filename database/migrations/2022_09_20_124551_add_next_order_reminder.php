<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNextOrderReminder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('support_cases', function (Blueprint $table) {
         
        
            $table->boolean('nextorderreminder')->default(false);
            $table->longText('nextorderremindert')->nullable();
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_cases', function (Blueprint $table) {
            $table->dropColumn('nextorderreminder');
            $table->dropColumn('nextorderremindert');
        });
    }
}
