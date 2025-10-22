<?php

namespace Modules\V1\Player\Services;

use Illuminate\Support\Facades\Redis;
use Modules\V1\Player\Enums\CacheKeyEnum;

final class RankerService
{
    public function storeOrUpdateScore(string $playerId, int $score): void
    {
        /**
         * @phpstan-ignore-next-line
         */
        Redis::zadd(CacheKeyEnum::RANKING_BOARD_CACHE_KEY->value, $score, $playerId);
    }

    public function getRank(string $playerId): ?int
    {
        /**
         * @phpstan-ignore-next-line
         */
        $rank = Redis::zrevrank(CacheKeyEnum::RANKING_BOARD_CACHE_KEY->value, $playerId);

        return $rank !== null ? (int) $rank + 1 : null;
    }

    /**
     * @return array<array<string, string>, mixed>
     */
    public function getTopPlayers(int $limit): array
    {
        /**
         * @phpstan-ignore-next-line
         */
        $results = Redis::zrevrange(CacheKeyEnum::RANKING_BOARD_CACHE_KEY->value, 0, $limit - 1, 'WITHSCORES');
        $players = [];
        foreach ($results as $score => $userId) {
            $score++;
            $players[] = [
                'id' => $userId,
                'score' => (int) $score,
            ];
        }

        return $players;
    }
}
