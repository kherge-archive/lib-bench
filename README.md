Bench
=========

[![Build Status][]](https://travis-ci.org/phine/lib-bench)
[![Coverage Status][]](https://coveralls.io/r/phine/lib-bench)
[![Latest Stable Version][]](https://packagist.org/packages/phine/bench)
[![Total Downloads][]](https://packagist.org/packages/phine/bench)

Simplifies the process of creating and running benchmarks. The library self-
calibrates so that the framework itself is not counted in the amount of time
it takes to complete any of the tests.

Usage
-----

```php
use Phine\Bench\Suite;
use Phine\Bench\Test;

$suite = new Suite();

$suite[] = new Test(
    function () {
        usleep(500);
    }
);

$suite['key'] = new Test(
    function () {
        sleep(1);
    }
);

$suite['setup'] = Test::create(
    function ($sleep, $usleep) {
        sleep($sleep);
        usleep($usleep);
    }
)->setSetup(
    function () {
        return array(
            rand(0, 2),
            rand(500, 1000)
        );
    }
);

list($total, $times) = $suite->run();

echo $total, "\n";          // 3.003720998764
echo $times[0], "\n";       // 0.0012569427490234
echo $times['key'], "\n";   // 1.0002269744873
echo $times['setup'], "\n"; // 2.0022370815277
```

Requirement
-----------

- PHP >= 5.3.3
- [Phine Exception][] >= 1.0

Installation
------------

Via [Composer][]:

    $ composer require "phine/bench=~1.0"

Documentation
-------------

You can find the documentation in the [`docs/`](docs/) directory.

License
-------

This library is available under the [MIT license](LICENSE).

[Build Status]: https://travis-ci.org/phine/lib-bench.png?branch=master
[Coverage Status]: https://coveralls.io/repos/phine/lib-bench/badge.png
[Latest Stable Version]: https://poser.pugx.org/phine/bench/v/stable.png
[Total Downloads]: https://poser.pugx.org/phine/bench/downloads.png
[Phine Exception]: https://github.com/phine/lib-exception
[Composer]: http://getcomposer.org/
