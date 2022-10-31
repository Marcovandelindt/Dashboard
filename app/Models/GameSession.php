<?php

namespace App\Models;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameSession extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'platform',
        'minutes_played',
        'date',
        'start_time',
        'end_time',
    ];

    /**
     * Get the game that belongs to this session
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
