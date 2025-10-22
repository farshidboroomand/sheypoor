<?php

namespace Modules\V1\Player\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\V1\Player\Models\Player;
use Modules\V1\Player\Services\RankerService;

/**
 * @mixin Player
 */
class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'score' => $this->score,
            'rank' => (new RankerService)->getRank($this->id),
        ];
    }
}
