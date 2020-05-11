<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->relation('notification_id','notifications');
            $table->relation('user_id','users');
            $table->boolean('is_read')->default(0);

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
        Schema::dropIfExists('notification_users');
    }
}
