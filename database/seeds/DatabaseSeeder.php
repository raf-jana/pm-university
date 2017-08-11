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
        $this->truncateMultiple(['placements', 'halls_of_knowledge']);
        factory(App\Models\HallsOfKnowledge::class, 3)->create();
        factory(App\Models\Placement::class, 2)->create();
    }
}
