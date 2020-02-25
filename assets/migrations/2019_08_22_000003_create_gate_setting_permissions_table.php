<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGateSettingPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gate_setting_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->relation('gate_setting_id', 'gate_settings');
            $table->relation('permission_id', 'permissions');

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
        Schema::dropIfExists('gate_setting_permissions');
    }
}
