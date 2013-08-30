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

    /**
     * Make sure that the setup callable is called, and that the returned
     * value is all passed to the test callable. The method should still
     * return the time it took to complete the test.
     */
    public function testRunSetup()
    {
        $args = array();
        $count = 0;

        $test = new Test(
            function ($a, $b, $c) use (&$args) {
                $args[] = array($a, $b, $c);
            }
        );

        set(
            $test,
            'setup',
            function () use (&$count) {
                return array($count++, $count++, $count++);
            }
        );

        $this->assertInternalType('float', $test->run());

        $test->run();

        $this->assertEquals(array(0, 1, 2), $args[0]);
        $this->assertEquals(array(3, 4, 5), $args[1]);
    }

    /**
     * Make sure that only an array is returned by the setup callable.
     */
    public function testRunSetupInvalid()
    {
        $test = new Test(function () {});

        set(
            $test,
            'setup',
            function () {
                return 123;
            }
        );

        $this->setExpectedException(
            'Phine\\Bench\\Exception\\BenchException',
            'Expected an array from the setup callable, integer received.'
        );

        $test->run();
    }

    /**
     * Make sure that we can set the setup callable. Also make sure that the
     * `setSetup()` method returns the instance it was called on. This should
     * make it easier to add tests to the suite, while also setting the setup
     * callable.
     */
    public function testSetSetup()
    {
        $test = new Test(function () {});

        $setup = function () {};

        $this->assertSame($test, $test->setSetup($setup));
        $this->assertSame($setup, get($test, 'setup'));
    }
}
