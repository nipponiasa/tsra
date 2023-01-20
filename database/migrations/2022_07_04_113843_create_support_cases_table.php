<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_cases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            $table->string('subject');
            $table->longText('description');
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('priority_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->integer('case_category_id')->unsigned()->nullable();
            $table->text('attached_files_folder_path')->nullable();
            $table->boolean('isaclaim')->default(false);
            $table->string('po')->nullable();;
            $table->boolean('claim_approved')->default(false);
            $table->longText('summary')->nullable();
            $table->string('issue1')->nullable();
            $table->string('issue2')->nullable();
            $table->string('issue3')->nullable();
            $table->boolean('nextoderreminder')->default(false);
            $table->longText('nextoderremindert')->nullable();

            });
    






    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_cases');
    }
}
