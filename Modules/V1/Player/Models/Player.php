<?php

namespace Modules\V1\Player\Models;

use App\Foundation\Traits\Uuid;
use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $username
 * @property int $score
 * @property int $rank
 */
class Player extends Model
{
    /**
     * @phpstan-ignore-next-line
     */
    use HasFactory;

    use Uuid;

    private static string $factory = PlayerFactory::class;

    protected $fillable = ['username', 'score'];
}
