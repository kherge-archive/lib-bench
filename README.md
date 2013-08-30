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

list($total, $times) = $suite->run();

echo $total;        // 1.0014040470123
echo $times[0];     // 0.00064706802368164
echo $times['key']; // 1.0007569789886
```

Requirement
-----------

- PHP >= 5.3.3

Installation
------------

Via [Composer][]:

    $ composer require "phine/bench=~1.0"

License
-------

This library is available under the [MIT license](LICENSE).

[Build Status]: https://travis-ci.org/phine/lib-bench.png?branch=master
[Coverage Status]: https://coveralls.io/repos/phine/lib-bench/badge.png
[Latest Stable Version]: https://poser.pugx.org/phine/bench/v/stable.png
[Total Downloads]: https://poser.pugx.org/phine/bench/downloads.png
[Composer]: http://getcomposer.org/
