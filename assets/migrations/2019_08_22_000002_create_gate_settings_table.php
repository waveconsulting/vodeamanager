<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gate_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->relation('role_id', 'roles');
            $table->relation('user_id', 'users');
            $table->date('valid_from')->useCurrent();

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
        Schema::dropIfExists('gate_settings');
    }
}
