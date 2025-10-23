<?php

namespace Modules\V1\Player\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Modules\V1\Player\Models\Player;
use Modules\V1\Player\Requests\StorePlayerRequest;
use Modules\V1\Player\Requests\UpdatePlayerScoreRequest;
use Modules\V1\Player\Resources\PlayerResource;
use Modules\V1\Player\Services\RankerService;

class PlayerController extends Controller
{
    private const LIMIT = 10;

    public function __construct(private readonly RankerService $ranker) {}

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

        $this->ranker->storeOrUpdateScore(
            playerId: $player->id,
            score: $input['score'] ?? 0
        );

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

            $this->ranker->storeOrUpdateScore(
                playerId: $player->id,
                score: $validatedScore['score'] ?? 0
            );

            return $row;
        });

        return new PlayerResource($player);
    }

    /**
     * @return PlayerResource
     */
    public function getPlayerRank(Player $player)
    {
        return new PlayerResource($player);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getTopPlayer(int $limit = self::LIMIT)
    {
        $topPlayers = $this->ranker->getTopPlayers($limit);
        $playerIds = array_column($topPlayers, 'id');
        /*** @phpstan-ignore-next-line */
        $players = Player::query()
            ->find($playerIds)
            ?->sortBy(function (Player $player) use ($playerIds) {
                return array_search($player->id, $playerIds, true);
            })->values();

        return PlayerResource::collection($players);
    }
}
