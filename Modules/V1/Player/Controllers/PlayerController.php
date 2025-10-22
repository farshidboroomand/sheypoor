<?php

namespace Modules\V1\Player\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\V1\Player\Models\Player;
use Modules\V1\Player\Requests\StorePlayerRequest;
use Modules\V1\Player\Requests\UpdatePlayerScoreRequest;
use Modules\V1\Player\Resources\PlayerResource;

class PlayerController extends Controller
{
    /**
     * @return PlayerResource
     */
    public function store(StorePlayerRequest $request)
    {
        $input = $request->validated();
        $player = Player::query()
            ->create([
                'username' => $input['username'],
                'score' => $input['score'] ?? 0,
            ]);

        return new PlayerResource($player);
    }

    /**
     * @return PlayerResource
     */
    public function updatePlayerScore(Player $player, UpdatePlayerScoreRequest $request)
    {
        $validatedScore = $request->validated();

        $player = DB::transaction(function () use ($player, $validatedScore) {
            /** @var Player $row */
            $row = Player::query()
                ->where('id', $player->id)
                ->lockForUpdate()
                ->firstOrFail();

            $row->score = $validatedScore['score'];
            $row->save();

            return $row;
        });

        return new PlayerResource($player);
    }
}
