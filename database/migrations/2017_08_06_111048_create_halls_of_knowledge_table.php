<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHallsOfKnowledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('halls_of_knowledge', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('picture')->nullable();
            $table->string('link')->nullable();
            $table->dateTime('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('halls_of_knowledge');
    }
}
