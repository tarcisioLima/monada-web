<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation', function (Blueprint $table) {
            $table->unsignedInteger('followerId')->nullable(false);
            $table->foreign('followerId')->references('id')->on('user');
            $table->unsignedInteger('followingId')->nullable(false);
            $table->foreign('followingId')->references('id')->on('user');
            $table->boolean('muted');
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
        Schema::dropIfExists('relation');
    }
}
