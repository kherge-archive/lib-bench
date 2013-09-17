<?php

namespace Phine\Bench\Tests;

use Phine\Bench\Suite;
use Phine\Bench\Test;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs a series of tests against the `Phine\Bench\Suite` class.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class SuiteTest extends TestCase
{
    /**
     * @var Suite
     */
    private $suite;

    /**
     * Makes sure we can `count()` the suite.
     */
    public function testCount()
    {
        $callable = function () {};

        $this->suite[] = new Test($callable);
        $this->suite[] = new Test($callable);
        $this->suite[] = new Test($callable);

        $this->assertEquals(3, count($this->suite));
    }

    /**
     * Makes sure that we can iterate through the suite.
     */
    public function testGetIterator()
    {
        $callable = function () {};
        $keys = array();

        $this->suite['a'] = new Test($callable);
        $this->suite['b'] = new Test($callable);
        $this->suite['c'] = new Test($callable);

        foreach ($this->suite as $key => $test) {
            $keys[] = $key;
        }

        $this->assertEquals('a', $keys[0]);
        $this->assertEquals('b', $keys[1]);
        $this->assertEquals('c', $keys[2]);
    }

    /**
     * Makes sure that we can check for existing array keys.
     */
    public function testOffsetExists()
    {
        $callable = function () {};

        $this->suite[] = new Test($callable);
        $this->suite[5] = new Test($callable);
        $this->suite['test'] = new Test($callable);

        $this->assertTrue(isset($this->suite[0]));
        $this->assertTrue(isset($this->suite[5]));
        $this->assertTrue(isset($this->suite['test']));
    }

    /**
     * Make sure we can retrieve array values.
     */
    public function testOffsetGet()
    {
        $callable = function () {};

        $a = $this->suite[] = new Test($callable);
        $b = $this->suite[5] = new Test($callable);
        $c = $this->suite['test'] = new Test($callable);

        $this->assertSame($a, $this->suite[0]);
        $this->assertSame($b, $this->suite[5]);
        $this->assertSame($c, $this->suite['test']);

    }

    /**
     * We've already been doing it, but for the sake of consistency, make
     * sure that we can set values using keys, and append values to the
     * end of the list.
     */
    public function testOffsetSet()
    {
        $callable = function () {};

        $a = $this->suite[] = new Test($callable);
        $b = $this->suite[5] = new Test($callable);
        $c = $this->suite['test'] = new Test($callable);

        $values = get($this->suite, 'tests');

        $this->assertSame($a, $values[0]);
        $this->assertSame($b, $values[5]);
        $this->assertSame($c, $values['test']);

    }

    /**
     * Make sure that only instances of `Phine\Bench\Test` can be added.
     */
    public function testOffsetSetInvalid()
    {
        $this->setExpectedException(
            'Phine\\Bench\\Exception\\BenchException',
            'Only instances of Phine\\Bench\\TestInterface are accepted as values.'
        );

        $this->suite[] = 123;
    }

    /**
     * Make sure we can unset tests that have been added.
     */
    public function testOffsetUnset()
    {
        $callable = function () {};

        $this->suite[] = new Test($callable);
        $this->suite[5] = new Test($callable);
        $this->suite['test'] = new Test($callable);

        unset($this->suite[0]);
        unset($this->suite[5]);
        unset($this->suite['test']);

        $this->assertFalse(isset($this->suite[0]));
        $this->assertFalse(isset($this->suite[5]));
        $this->assertFalse(isset($this->suite['test']));
    }

    /**
     * Make sure we can run the whole test suite, and we get back the times
     * for all of them. Also make sure that each time given back corresponds
     * to the same key for the test the time belongs to.
     */
    public function testRun()
    {
        $count = 0;
        $callable = function () use (&$count) {
            $count++;
        };

        $this->suite[] = new Test($callable);
        $this->suite[5] = new Test($callable);
        $this->suite['test'] = new Test($callable);

        list($total, $times) = $this->suite->run();

        $this->assertCount(3, $times);
        $this->assertEquals($total, array_sum($times));
        $this->assertTrue(isset($times[0]));
        $this->assertTrue(isset($times[5]));
        $this->assertTrue(isset($times['test']));
    }

    protected function setUp()
    {
        $this->suite = new Suite();
    }
}
