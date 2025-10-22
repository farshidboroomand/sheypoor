<?php

namespace Modules\V1\Player\Controllers;

use App\Http\Controllers\Controller;
use Modules\V1\Player\Models\Player;
use Modules\V1\Player\Requests\StorePlayerRequest;
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
}
