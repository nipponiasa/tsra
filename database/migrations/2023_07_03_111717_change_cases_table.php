<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("support_cases","technical_cases");
        Schema::table("technical_cases", function (Blueprint $table) {
            $table->dropColumn(["issue1","issue2","issue3","isaclaim"]);
            $table->renameColumn("nextorderreminder","reminder");
            $table->renameColumn("nextorderremindert","reminder_desc");
            $table->renameColumn("po","purchase_order");
            $table->renameColumn("claim_approved","approved");
            $table->renameColumn("summary","notes");
            $table->renameColumn("case_category_id","category_id");
        });
        //it needs separate step, because each step is validated (by MySQL) as a whole before gets executed
        Schema::table("technical_cases", function (Blueprint $table) {      
            $table->string("subcategory_id")->nullable()->after('category_id');
            $table->string('model')->nullable()->after('agent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("technical_cases", function (Blueprint $table) {
            $table->dropColumn(["subcategory_id", "model"]);
            $table->renameColumn("reminder", "nextorderreminder");
            $table->renameColumn("reminder_desc", "nextorderremindert");
            $table->renameColumn("purchase_order", "po");
            $table->renameColumn("approved","claim_approved");
            $table->renameColumn("notes", "summary");
            $table->renameColumn("category_id", "case_category_id");
            $table->string("issue1");
            $table->string("issue2");
            $table->string("issue3");
            $table->boolean("isaclaim");
        });
        Schema::rename("technical_cases", "support_cases");
    }
}
