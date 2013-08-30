<?php

namespace Phine\Bench\Tests;

use Phine\Bench\Test;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs a series of tests on the `Phine\Bench\Test` class.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class TestTest extends TestCase
{
    /**
     * Checks to make sure that the calibration is performed, and that the
     * test callable is properly set. While this may not be the first `Test`
     * instance created, the `Test::$offset` property should still have been
     * updated.
     */
    public function testConstruct()
    {
        $callable = function () {};

        $test = new Test($callable);

        $this->assertNotNull(get($test, 'offset'));
        $this->assertSame($callable, get($test, 'test'));
    }

    /**
     * Ensure that an exception is thrown if an invalid argument is given.
     */
    public function testConstructInvalid()
    {
        $this->setExpectedException(
            'Phine\\Bench\\Exception\\BenchException',
            'The $test is expected to be a callable, integer received.'
        );

        new Test(123);
    }

    /**
     * Make sure that a new instance of `Test` is returned by `create()`.
     */
    public function testCreate()
    {
        $callback = function () {};

        $this->assertInstanceOf('Phine\\Bench\\Test', Test::create($callback));
        $this->assertNotSame(Test::create($callback), Test::create($callback));
    }

    /**
     * Ensure that the amount of time taken is returned.
     */
    public function testRun()
    {
        $test = new Test(
            function () {
                usleep(500);
            }
        );

        $time = $test->run();

        $this->assertGreaterThan(0.0005, $time);
        $this->assertLessThan(0.01, $time);
    }
}
