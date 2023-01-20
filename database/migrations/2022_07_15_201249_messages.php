<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('message')->default("")->nullable(); //message apo th forma
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->integer('case_category_id')->unsigned()->nullable();
            $table->integer('support_case_id')->unsigned()->nullable();
            $table->string('mail_id')->nullable;
            $table->string('mail_internetMessageId')->nullable;
            $table->string('mail_subject')->nullable;
            $table->text('mail_body_content')->nullable;
            $table->text('mail_weblink')->nullable;
            $table->string('mail_conversationId')->nullable;
            $table->string('mail_conversationIndex')->nullable;
            $table->text('mail_from')->nullable;
            $table->datetime('mail_sentDateTime')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable;
            $table->datetime('mail_receivedDateTime')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable;
            $table->string('type')->default("Technical Report")->nullable();//typos mynhmatos (ayto tha mporouse na to pernei apo to )
            $table->string('message_type')->default("")->nullable; //clent h vendor
            $table->string('mail_type')->default("")->nullable; //in out
            $table->string('subject')->default("")->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
