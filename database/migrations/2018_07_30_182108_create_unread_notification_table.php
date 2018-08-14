<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnreadNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unread_notification', function (Blueprint $table){
            $table->increments('id');
            $table->enum('action', ['LIKE', 'RELATION', 'PUBLICATION', 'SYSTEM'])->nullable(false);
            $table->unsignedInteger('actionId');
            $table->unsignedInteger('userId')->nullable(false);
            $table->foreign('userId')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unread_notification');
    }
}
