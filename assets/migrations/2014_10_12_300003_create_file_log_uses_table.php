<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileLogUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_log_uses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->relation('file_log_id', 'file_logs');
            $table->string('entity')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();

            $table->userTimeStamp();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_log_uses');
    }
}
