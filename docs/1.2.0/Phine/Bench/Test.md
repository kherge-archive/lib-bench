<small>Phine\Bench</small>

Test
====

Manages the execution of an individual callable as a test case.

Signature
---------

- It is a(n) **class**.
- It implements the [`TestInterface`](../../Phine/Bench/TestInterface.md) interface.

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Sets the test callable.
- [`create()`](#create)
- [`run()`](#run) &mdash; Runs the test and returns the amount of time it took to complete.
- [`setSetup()`](#setSetup) &mdash; Sets the test setup callable.

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
    - `$test` ([`callable`](http://php.net/class.Phine\Bench\callable)) &mdash; The test to perform.
- It does not return anything.
- It throws one of the following exceptions:
    - [`Exception`](http://php.net/class.Exception) &mdash; 
    - [`BenchException`](http://php.net/class.BenchException) &mdash; If `$test` is not valid.

### `create()` <a name="create"></a>

#### See Also

- `Test::__construct`

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$test`
- It does not return anything.

### `run()` <a name="run"></a>

Runs the test and returns the amount of time it took to complete.

#### Signature

- It is a **public** method.
- It returns a(n) [`float`](http://php.net/class.Phine\Bench\float) value.
- It throws one of the following exceptions:
    - [`Exception`](http://php.net/class.Exception) &mdash; 
    - [`BenchException`](http://php.net/class.BenchException) &mdash; If the setup return value is not an array.

### `setSetup()` <a name="setSetup"></a>

Sets the test setup callable.

#### Description

A setup callable will return an array of arguments that will be passed
on to the test callable. This setup process is useful if it is unique
to the test, but must not be counted as part of the time used in the
benchmark.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$setup` ([`callable`](http://php.net/class.Phine\Bench\callable)) &mdash; The setup callable.
- It returns a(n) [`Test`](../../Phine/Bench/Test.md) value.

