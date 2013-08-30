<?php

namespace Phine\Bench;

use Phine\Bench\Exception\BenchException;
use Phine\Exception\Exception;

/**
 * Manages the execution of an individual test.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Test
{
    /**
     * The time to offset for compensation.
     *
     * @var float
     */
    private static $offset;

    /**
     * The test to perform.
     *
     * @var callable
     */
    private $test;

    /**
     * Sets the test callable.
     *
     * In addition to setting the test callable, the class will perform a
     * self-calibration when the first instance is created. This calibration
     * is used to account for time taken by the class to actually perform the
     * timing for the test.
     *
     * @param callable $test The test to perform.
     *
     * @throws Exception
     * @throws BenchException If `$test` is not valid.
     */
    public function __construct($test)
    {
        if (null === self::$offset) {
            $this->calibrate();
        }

        if (!is_callable($test)) {
            throw BenchException::createUsingFormat(
                'The $test is expected to be a callable, %s received.',
                gettype($test)
            );
        }

        $this->test = $test;
    }

    /**
     * Runs the test and returns the amount of time it took to complete.
     *
     * @return float The amount of time taken in microseconds.
     */
    public function run()
    {
        $start = microtime(true);

        call_user_func($this->test);

        $finish = microtime(true);
        $finish -= $start;
        $finish -= self::$offset;

        return $finish;
    }

    /**
     * Performs self-calibration.
     */
    private function calibrate()
    {
        $start = microtime(true);

        call_user_func(function () {});

        $finish = microtime(true);

        self::$offset = $finish - $start;
    }
}