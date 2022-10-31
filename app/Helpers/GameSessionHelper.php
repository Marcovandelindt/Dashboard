<?php

namespace App\Helpers;

use App\Models\Game;
use App\Models\GameSession;
use Carbon\Carbon;

class GameSessionHelper 
{
    /**
     * Calculate the total playtime
     */
    public static function calculateTotalPlayTime()
    {
        $totalPlayTime = 0;

        foreach (GameSession::all() as $gameSession) {
            $totalPlayTime = $totalPlayTime + $gameSession->minutes_played;
        }

        if (!empty($totalPlayTime)) {
            $totalSeconds = $totalPlayTime * 60;

            $dateTime = new \DateTime("@0");
            $dateTimeSeconds = new \DateTime("@$totalSeconds");

            return $dateTimeSeconds->diff($dateTime)->format('%a days, %h hours and %i minutes');
        }
    }

    /**
     * Convert to minutes
     */
    public static function convertToMinutes($time)
    {
        if (str_contains($time, 'hours')) {
            $strippedPlayTime = str_replace('hours', '', $time);
            $minutes = 0;
            list($strippedPlayTime, $minutes) = explode(':', $strippedPlayTime);

            $strippedPlayTimeMinutes = $strippedPlayTime * 60 + $minutes;

            return $strippedPlayTimeMinutes;
        } elseif (str_contains($time, 'minutes')) {
            $strippedPlayTime = str_replace(' minutes', '', $time);
            
            return $strippedPlayTime;
        }  elseif (str_contains($time, 'minute')) {
            $strippedPlayTime = str_replace(' minute', '', $time);
            
            return $strippedPlayTime;
        }
    }

    /**
     * Convert the minutes to hours
     * 
     * @param int $time
     * @param string $format
     * 
     * @return mixed string | bool
     */
    public static function convertToHours($time, $format = '%02d:%02d'): string 
    {
        if ($time < 1) {
            return false;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    /**
     * Get most played game based on a timeframe
     * 
     * @param mixed $timeframe
     * 
     * @return string
     */
    public static function getMostPlayedGame($timeframe = null): string 
    {

        if (!empty($timeframe)) {
            switch ($timeframe) {
                case 'weekly':
                    $now       = Carbon::now();
                    $weekStart = $now->startOfWeek()->format('Y-m-d');
                    $weekEnd   = $now->endOfWeek()->format('Y-m-d');

                    $gameSessions = GameSession::all()->where('date', '>=', $weekStart)->where('date', '<=', $weekEnd)->groupBy('game_id');

                    break;
            }
        } else {
            $gameSessions = GameSession::all()->groupBy('game_id');
        }

        $totalMinutes = [];
        foreach ($gameSessions as $groupedGameSessions) {
            foreach ($groupedGameSessions as $groupedGameSession) {

                if (!isset($totalMinutes[$groupedGameSession->game_id])) {
                    $totalMinutes[$groupedGameSession->game_id] = 0;
                }

                $totalMinutes[$groupedGameSession->game_id] = $totalMinutes[$groupedGameSession->game_id] + $groupedGameSession->minutes_played;
            }
        }

        $mostPlayed    = max($totalMinutes);
        $mostPlayedKey = array_search($mostPlayed, $totalMinutes);
        $game          = Game::where('id', $mostPlayedKey)->first();

        if (!empty($mostPlayed) && !empty($game)) {
            $totalPlayTimeInHours = self::convertToHours($mostPlayed, '%2d hours %02d minutes');

            return $game->name . ' (' . $totalPlayTimeInHours . ')';
        }
    }
}