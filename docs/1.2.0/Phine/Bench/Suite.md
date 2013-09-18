<small>Phine\Bench</small>

Suite
=====

Manages a suite of individual tests.

Signature
---------

- It is a(n) **class**.
- It implements the following interfaces:
    - [`ArrayAccess`](http://php.net/class.ArrayAccess)
    - [`Countable`](http://php.net/class.Countable)
    - [`IteratorAggregate`](http://php.net/class.IteratorAggregate)

Methods
-------

The class defines the following methods:

- [`count()`](#count) &mdash; {@inheritDoc}
- [`getIterator()`](#getIterator) &mdash; {@inheritDoc}
- [`offsetExists()`](#offsetExists) &mdash; {@inheritDoc}
- [`offsetGet()`](#offsetGet) &mdash; {@inheritDoc}
- [`offsetSet()`](#offsetSet) &mdash; {@inheritDoc}
- [`offsetUnset()`](#offsetUnset) &mdash; {@inheritDoc}
- [`run()`](#run) &mdash; Runs the suite of tests and returns the times taken.

### `count()` <a name="count"></a>

{@inheritDoc}

#### Signature

- It is a **public** method.
- It does not return anything.

### `getIterator()` <a name="getIterator"></a>

{@inheritDoc}

#### Signature

- It is a **public** method.
- It does not return anything.

### `offsetExists()` <a name="offsetExists"></a>

{@inheritDoc}

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$offset`
- It does not return anything.

### `offsetGet()` <a name="offsetGet"></a>

{@inheritDoc}

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$offset`
- It does not return anything.

### `offsetSet()` <a name="offsetSet"></a>

{@inheritDoc}

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$offset`
    - `$value`
- It does not return anything.
- It throws one of the following exceptions:
    - [`Exception`](http://php.net/class.Exception)
    - `BenchException` &mdash; If the value is not a `Test` instance.

### `offsetUnset()` <a name="offsetUnset"></a>

{@inheritDoc}

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$offset`
- It does not return anything.

### `run()` <a name="run"></a>

Runs the suite of tests and returns the times taken.

#### Description

The array returned consists of two values. The first value is the
sum of all test result times. The second value is an array of all
times for each test run. The keys for that array correspond to the
keys used for each test.

    list($total, $times) = $suite-&gt;run();

#### Signature

- It is a **public** method.
- It returns a(n) `array` value.

