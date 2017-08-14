<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 50)
                ->default(\App\Models\Post::BACHELORE);
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('last_user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->mediumText('summary')->nullable();
            $table->string('note_title')->nullable();
            $table->longText('note_description')->nullable();
            $table->string('picture', 255)->nullable();
            $table->string('hover_picture', 255)->nullable();
            $table->string('h1')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->dateTime('published_at')->nullable()->index();
            $table->timestamps();

            $table->index(['slug', 'published_at']);
            $table->index(['type', 'published_at']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}