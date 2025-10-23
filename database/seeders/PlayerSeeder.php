<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\V1\Player\Models\Player;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::factory()->count(10)->create();
    }
}
