<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $columns = ['Todo', 'In progress', 'Review', 'Done'];
        foreach ($columns as $column) {
            Column::create(['title' => $column]);
        }
        Card::factory(10)->create();
    }
}
