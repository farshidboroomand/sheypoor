<?php

namespace Modules\V1\Player\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNewPlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_a_new_player_can_be_created(): void
    {
        $body = [
            'username' => 'Ozzy Osbourne',
        ];

        $response = $this->postJson(route('api.v1.player.store'), $body);

        $response->assertCreated();

        $this->assertDatabaseCount('players', 1);
        $this->assertDatabaseHas('players', [
            'username' => 'Ozzy Osbourne',
            'score' => 0,
        ]);
    }

    public function test_if_player_validation_returns_error(): void
    {
        $response = $this->postJson(route('api.v1.player.store'));

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }
}
