<?php

namespace Phine\Bench;

use Phine\Bench\Exception\BenchException;
use Phine\Exception\Exception;

/**
 * Defines how a test case must be implemented.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface TestInterface
{
    /**
     * Runs the test and returns the amount of time it took to complete.
     *
     * @return float The amount of time taken in microseconds.
     *
     * @throws Exception
     * @throws BenchException If the setup return value is not an array.
     */
    public function run();
}
