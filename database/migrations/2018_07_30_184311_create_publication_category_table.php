<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_category', function (Blueprint $table) {
            $table->unsignedInteger('publicationId')->nullable(false);
            $table->foreign('publicationId')->references('id')->on('publication');
            $table->unsignedInteger('categoryId')->nullable(false);
            $table->foreign('categoryId')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication_category');
    }
}
