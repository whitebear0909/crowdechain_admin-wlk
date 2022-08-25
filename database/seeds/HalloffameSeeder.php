<?php

use Illuminate\Database\Seeder;

class HalloffameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Models\Halloffame::class, 30)->create();
    }
}
