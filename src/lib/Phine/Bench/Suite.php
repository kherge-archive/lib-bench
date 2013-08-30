<?php

namespace Phine\Bench;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Phine\Bench\Exception\BenchException;

/**
 * Manages a suite of individual tests.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Suite implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * The suite of tests.
     *
     * @var Test[]
     */
    private $tests = array();

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->tests);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->tests);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->tests[$offset]);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->tests[$offset];
    }

    /**
     * {@inheritDoc}
     *
     * @throws BenchException If the value is not a `Test` instance.
     */
    public function offsetSet($offset, $value)
    {
        if (!($value instanceof Test)) {
            throw new BenchException(
                'Only instances of Phine\\Bench\\Test are accepted as values.'
            );
        }

        if (null === $offset) {
            $this->tests[] = $value;
        } else {
            $this->tests[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->tests[$offset]);
    }

    /**
     * Runs the suite of tests and returns the times taken.
     *
     * The array returned consists of two values. The first value is the
     * sum of all test result times. The second value is an array of all
     * times for each test run. The keys for that array correspond to the
     * keys used for each test.
     *
     *     list($total, $times) = $suite->run();
     *
     * @return array The test times.
     */
    public function run()
    {
        $times = array();
        $total = 0;

        foreach ($this->tests as $key => $test) {
            $total += $times[$key] = $test->run();
        }

        return array($total, $times);
    }
}
