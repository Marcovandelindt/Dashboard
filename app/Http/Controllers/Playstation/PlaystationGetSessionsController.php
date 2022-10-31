<?php

namespace App\Http\Controllers\Playstation;

use App\Models\Game;
use App\Models\GameSession;
use App\Helpers\GameSessionHelper;
use Goutte\Client as GoutteClient;
use App\Http\Controllers\Controller;

class PlaystationGetSessionsController extends Controller 
{
    /**
     * Get the playstation sessions
     */
    public function index()
    {
        $goutteClient = new GoutteClient;

        $crawler = $goutteClient->request('GET', env('PS_TIMETRACKER_URL'));

        $gameInfo = [];
        $crawler->filter('tbody > tr')->each(function ($node, $i) use (&$gameInfo) {
            $count = 1;
            $node->filter('td')->each(function ($tdNode) use (&$i, &$gameInfo, &$count) {
                if (!empty($tdNode->text())) {
                    if ($count == 1) {
                        $gameInfo[$i]['game_name'] = $tdNode->text();
                    }

                    if ($count == 2) {
                        $gameInfo[$i]['platform'] = $tdNode->text();
                    }

                    if ($count == 3) {
                        $gameInfo[$i]['hours_played'] = $tdNode->text();
                    }

                    if ($count == 4) {
                        $gameInfo[$i]['start_time'] = $tdNode->text();
                    }

                    if ($count == 5) {
                        $gameInfo[$i]['end_time'] = $tdNode->text();
                    }

                    $count++;
                }
            });
        });

        foreach ($gameInfo as $gameInfoRow) {
            $minutesPlayed = GameSessionHelper::convertToMinutes($gameInfoRow['hours_played']);
            $date = date('Y-m-d', strtotime($gameInfoRow['start_time']));

            if (!GameSession::where(['minutes_played' => $minutesPlayed, 'date' => $date, 'start_time' => $gameInfoRow['start_time'] . ':00', 'end_time' => $gameInfoRow['end_time'] . ':00'])->first()) {
                 // Check if the game exists
                 if (!Game::where('name', $gameInfoRow['game_name'])->first()) {
                    $game = new Game();
                    $game->name = $gameInfoRow['game_name'];
                    $game->save();
                }

                $storedGame = Game::where('name', $gameInfoRow['game_name'])->first();

                $gameSession               = new GameSession;
                $gameSession->game_id      = $storedGame->id;
                $gameSession->platform     = $gameInfoRow['platform'];
                $gameSession->minutes_played = $minutesPlayed;
                $gameSession->date = $date;
                $gameSession->start_time   = $gameInfoRow['start_time'];
                $gameSession->end_time     = $gameInfoRow['end_time'];

                try {
                    $gameSession->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }

        return redirect()->route('home');
    }
}