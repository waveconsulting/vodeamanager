<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberSettingComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_setting_components', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->relation('number_setting_id', 'number_settings');
            $table->unsignedInteger('sequence')->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();

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
        Schema::dropIfExists('number_setting_components');
    }
}
