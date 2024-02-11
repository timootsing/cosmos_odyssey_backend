<?php

namespace App\Util;

use App\Choice\Season;

class SeasonHandler
{
    /**
     * @param string $season
     * @return int[]
     */
    public static function getMonths(string $season): array
    {
        return match ($season) {
            Season::SUMMER => [6, 7, 8],
            Season::AUTUMN => [9, 10, 11],
            Season::WINTER => [12, 1, 2],
            Season::SPRING => [3, 4, 5],
        };
    }

}
