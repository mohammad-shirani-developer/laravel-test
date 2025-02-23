<?php

namespace Tests\Unit;

use App\Helpers\DurationOfReading;
use PHPUnit\Framework\TestCase;

class DurationReadingTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testCanGetDurationOfReadingText(): void
    {
        $text = 'This iS For Test';

        $dor = new DurationOfReading();
        $dor->setText($text);

        $this->assertEquals(4, $dor->getTimePerSecond());
        $this->assertEquals(4 / 60, $dor->getTimePerMiunte());
    }
}
