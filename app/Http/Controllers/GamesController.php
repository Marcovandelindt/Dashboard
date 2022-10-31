<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameSession;
use App\Helpers\GameSessionHelper;
use Illuminate\Contracts\View\View;

class GamesController extends Controller 
{
    /**
     * Index action
     * 
     * @return View
     */
    public function index(): View
    {
        $games = Game::all();
        $gameSessions = GameSession::paginate(100);
        $totalPlayTime = GameSessionHelper::calculateTotalPlayTime();

        $data = [
            'title' => 'Games',
            'games' => $games,
            'totalPlayTime' => $totalPlayTime,
            'gameSessions' => $gameSessions,
            'mostPlayedGame' => GameSessionHelper::getMostPlayedGame('weekly'),
        ];

        return view('games.index')->with($data);
    }
}