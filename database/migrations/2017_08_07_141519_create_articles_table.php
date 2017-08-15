<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id')->index();
            $table->string('type', 50)
                ->default(\App\Models\Article::BOOKS);
            $table->string('source_url')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('picture', 255)->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('last_user_id')->nullable();
            $table->dateTime('published_at')->nullable()->index();
            $table->timestamps();

            $table->index(['post_id', 'published_at']);
            $table->index(['post_id', 'type', 'published_at']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');;

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
