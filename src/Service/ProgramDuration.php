<?php

namespace App\Service;

use App\Entity\Program;
use DateInterval;

class ProgramDuration
{

    public function calculate(Program $program): string
    {
        $totalDuration = 0;
        foreach ($program->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $totalDuration += $episode->getDuration();
            }
        }

        $hours = floor($totalDuration / 60);
        $days = ($hours > 24) ? floor($hours / 24) : 0;
        $minutes = $totalDuration - ($hours * 60);

        return ($days > 0) ? $days . ' jour(s), ' . $hours . ' heure(s) et ' . $minutes . '  minutes.' : $hours . ' heures et ' . $minutes . 'minutes.';
    }
}
