<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTechnicalDirectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_directives', function(Blueprint $table) {
            $table->renameColumn('directive', 'notes');
            $table->renameColumn('publish_state', 'state');
            $table->string('filepath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_directives', function(Blueprint $table) {
            $table->renameColumn('notes', 'directive');
            $table->renameColumn('state', 'publish_state');
            $table->dropColumn('filepath');
        });
    }
}
