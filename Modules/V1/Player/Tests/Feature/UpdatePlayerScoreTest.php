<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\V1\Player\Models\Player;
use Tests\TestCase;

class UpdatePlayerScoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_player_score_can_be_updated(): void
    {
        /** @var Player $player */
        $player = Player::factory()->create(['score' => 100]);
        $updateScore = 600;

        $response = $this->patchJson(
            route('api.v1.player.update.score', ['player' => $player->id]),
            ['score' => $updateScore]
        );

        $response->assertStatus(200);
        $response->assertExactJson([
            'data' => [
                'id' => $player->id,
                'username' => $player->username,
                'score' => $updateScore,
            ],
        ]);
    }
}
