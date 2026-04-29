<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stage;

class StageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['name' => 'Proposal', 'order' => 1],
            ['name' => 'Design', 'order' => 2],
            ['name' => 'Implementation', 'order' => 3],
            ['name' => 'Testing', 'order' => 4],
            ['name' => 'Report', 'order' => 5],
        ];

        foreach ($stages as $stage) {
            Stage::create($stage);
        }
    }
   
}
