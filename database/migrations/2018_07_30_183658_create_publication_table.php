<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication', function (Blueprint $table){
            $table->increments('id');
            $table->string('title', 100);
            $table->mediumText('description');
            $table->string('link');
            $table->boolean('draft');
            $table->timestamp('date')->useCurrent();
            $table->unsignedInteger('authorId')->nullable(false);
            $table->foreign('authorId')->references('id')->on('author');
            $table->unsignedInteger('folderId');
            $table->foreign('folderId')->references('id')->on('folder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication');
    }
}
