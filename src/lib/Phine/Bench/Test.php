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
     * The setup for the test.
     *
     * @var callable
     */
    private $setup;

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
     * @see Test::__construct
     */
    public static function create($test)
    {
        return new self($test);
    }

    /**
     * Runs the test and returns the amount of time it took to complete.
     *
     * @return float The amount of time taken in microseconds.
     *
     * @throws Exception
     * @throws BenchException If the setup return value is not an array.
     */
    public function run()
    {
        if ($this->setup) {
            $setup = call_user_func($this->setup);

            if (!is_array($setup)) {
                throw BenchException::createUsingFormat(
                    'Expected an array from the setup callable, %s received.',
                    gettype($setup)
                );
            }

            $start = microtime(true);

            call_user_func_array($this->test, $setup);
        } else {
            $start = microtime(true);

            call_user_func($this->test);
        }

        $finish = microtime(true);
        $finish -= $start;
        $finish -= self::$offset;

        return $finish;
    }

    /**
     * Sets the test setup callable.
     *
     * A setup callable will return an array of arguments that will be passed
     * on to the test callable. This setup process is useful if it is unique
     * to the test, but must not be counted as part of the time used in the
     * benchmark.
     *
     * @param callable $setup The setup callable.
     *
     * @return Test The `Test` instance.
     */
    public function setSetup($setup)
    {
        $this->setup = $setup;

        return $this;
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
