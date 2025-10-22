<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Player\Models\Player;
use Tests\TestCase;

class GetPlayerRankTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_player_rank_calculated_correctly(): void
    {
        Player::factory()->create(['score' => 100]);
        Player::factory()->create(['score' => 200]);
        /** @var Player $player */
        $player = Player::factory()->create(['score' => 300]);

        $response = $this->get(route('api.v1.player.rank', $player->id));
        $response->assertStatus(200);
        $response->assertExactJson([
            'data' => [
                'id' => $player->id,
                'username' => $player->username,
                'score' => 300,
                'rank' => 1,
            ],
        ]);
    }
}
