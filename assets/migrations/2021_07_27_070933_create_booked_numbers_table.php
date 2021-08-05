<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookedNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_numbers', function (Blueprint $table) {
            $table->id();

            $table->uuidMorphs('subject');
            $table->relation('number_setting_id', 'number_settings', false);
            $table->string('number');

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
        Schema::dropIfExists('booked_numbers');
    }
}
