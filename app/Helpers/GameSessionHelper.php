<?php

namespace App\Helpers;

use App\Models\Game;
use App\Models\GameSession;

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
}