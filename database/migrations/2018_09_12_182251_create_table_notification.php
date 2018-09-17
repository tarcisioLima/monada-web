<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->boolean('read');
            $table->enum('action', ['RELATION','LIKE', 'COMMENT', 'SYSTEM', 'SECURITY']);
            $table->unsignedInteger('actionId')->nullable();
            $table->unsignedInteger('userId');
            $table->foreign('userId')->references('id')->on('user');
            $table->timestamp('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
