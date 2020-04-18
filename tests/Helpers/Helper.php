<?php

namespace Cloudmazing\Tikkie\Tests\Helpers;

use Illuminate\Support\Carbon;
use Faker\Factory;

class Helper
{
    /**
     * Get a random string of a given size
     *
     * @param int $size
     * @return string
     */
    static public function getRandomString(int $size = 20): string {
        return (Factory::create())->lexify(str_pad('', $size, '?'));
    }

    /**
     * Get a random number of a given size
     *
     * @param int $size
     * @return int
     */
    static public function getRandomNumber(int $size = 4): int {
        return intval((Factory::create())->numerify(str_pad('', $size, '#')), 10);
    }

    /**
     * Get a random future date
     *
     * @return Carbon
     */
    static public function getRandomFutureCarbonDate(): Carbon
    {
        return (new Carbon())->addDays(self::getRandomNumber(1))->setMicros(0);
    }

    /**
     * Get the current Carbon date
     *
     * @return Carbon
     */
    static public function getCarbonDate(): Carbon
    {
        return (new Carbon())->setMicros(0);
    }

    /**
     * Returns a random URL
     *
     * @return string
     */
    static public function getRandomUrl(): string {
        return "https://".self::getRandomString(3).".".self::getRandomString(10).".com";
    }
}
