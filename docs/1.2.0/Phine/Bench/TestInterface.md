<small>Phine\Bench</small>

TestInterface
=============

Defines how a test case must be implemented.

Signature
---------

- It is a(n) **interface**.

Methods
-------

The interface defines the following methods:

- [`run()`](#run) &mdash; Runs the test and returns the amount of time it took to complete.

### `run()` <a name="run"></a>

Runs the test and returns the amount of time it took to complete.

#### Signature

- It is a **public** method.
- It returns a(n) `Phine\Bench\float` value.
- It throws one of the following exceptions:
    - [`Exception`](http://php.net/class.Exception)
    - `BenchException` &mdash; If the setup return value is not an array.

