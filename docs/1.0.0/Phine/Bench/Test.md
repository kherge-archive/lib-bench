<small>Phine\Bench</small>

Test
====

Manages the execution of an individual test.

Signature
---------

- It is a(n) **class**.

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Sets the test callable.
- [`run()`](#run) &mdash; Runs the test and returns the amount of time it took to complete.

### `__construct()` <a name="__construct"></a>

Sets the test callable.

#### Description

In addition to setting the test callable, the class will perform a
self-calibration when the first instance is created. This calibration
is used to account for time taken by the class to actually perform the
timing for the test.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$test` (`Phine\Bench\callable`) &mdash; The test to perform.
- It does not return anything.
- It throws one of the following exceptions:
    - [`Exception`](http://php.net/class.Exception)
    - `BenchException` &mdash; If `$test` is not valid.

### `run()` <a name="run"></a>

Runs the test and returns the amount of time it took to complete.

#### Signature

- It is a **public** method.
- It returns a(n) `Phine\Bench\float` value.

