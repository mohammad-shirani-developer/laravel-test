<?php

namespace App\Helpers;


class DurationOfReading
{
    private $timePerWorld = 1;

    private $worldLength;

    private $duration;

    public function setText(string $text)
    {
        $this->worldLength = count(explode(" ", $text));

        $this->duration = $this->worldLength * $this->timePerWorld;

        return $this;
    }

    public function getTimePerSecond()
    {
        return $this->duration;
    }

    public function getTimePerMiunte()
    {
        return $this->duration / 60;
    }
}
