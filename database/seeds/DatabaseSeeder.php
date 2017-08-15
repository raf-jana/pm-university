<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use \Database\TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->truncateMultiple(['placements', 'halls_of_knowledge']);
        //factory(App\Models\HallsOfKnowledge::class, 3)->create();
        //factory(App\Models\Placement::class, 2)->create();

        /*$topics = DB::connection('legacy_mysql')
            ->table('topics')->get();
        foreach ($topics as $topic) {
            $userId = $topic->user_id;
            $createdAt = $topic->created_at;
            \App\Models\Post::create([
                'id' => $topic->id,
                'user_id' => $userId,
                'last_user_id' => $userId,
                'title' => $topic->title,
                'slug' => $topic->slug,
                'summary' => $topic->summary,
                'type' => $topic->level_title,
                'note_title' => $topic->note_title,
                'note_description' => $topic->note_description,
                'picture' => $topic->web_picture,
                'created_at' => $createdAt,
                'published_at' => $createdAt
            ]);
        } */

        /*$articles = DB::connection('legacy_mysql')
            ->table('articles')->get();
        foreach ($articles as $article) {
            if (\App\Models\Post::find($article->topic_id)) {
                $userId = $article->user_id;
                $createdAt = $article->created_at;
                \App\Models\Article::create([
                    'id' => $article->id,
                    'post_id' => $article->topic_id,
                    'user_id' => $userId,
                    'last_user_id' => $userId,
                    'title' => $article->title,
                    'source_url' => $article->source_url,
                    'type' => $article->type_title,
                    'video_url' => $article->video_url,
                    'description' => $article->description,
                    'picture' => $article->web_picture,
                    'created_at' => $createdAt,
                    'published_at' => $createdAt
                ]);
            }
        }*/
    }
}
