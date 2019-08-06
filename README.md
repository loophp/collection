[![Latest Stable Version](https://img.shields.io/packagist/v/drupol/collection.svg?style=flat-square)](https://packagist.org/packages/drupol/collection)
 [![GitHub stars](https://img.shields.io/github/stars/drupol/collection.svg?style=flat-square)](https://packagist.org/packages/drupol/collection)
 [![Total Downloads](https://img.shields.io/packagist/dt/drupol/collection.svg?style=flat-square)](https://packagist.org/packages/drupol/collection)
 [![Build Status](https://img.shields.io/travis/drupol/collection/master.svg?style=flat-square)](https://travis-ci.org/drupol/collection)
 [![Scrutinizer code quality](https://img.shields.io/scrutinizer/quality/g/drupol/collection/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/collection/?branch=master)
 [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/drupol/collection/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/collection/?branch=master)
 [![Mutation testing badge](https://badge.stryker-mutator.io/github.com/drupol/collection/master)](https://stryker-mutator.github.io)
 [![License](https://img.shields.io/packagist/l/drupol/collection.svg?style=flat-square)](https://packagist.org/packages/drupol/collection)
 [![Say Thanks!](https://img.shields.io/badge/Say-thanks-brightgreen.svg?style=flat-square)](https://saythanks.io/to/drupol)
 [![Donate!](https://img.shields.io/badge/Donate-Paypal-brightgreen.svg?style=flat-square)](https://paypal.me/drupol)
 
# PHP Collection

## Description

A Collection is an object that can hold a list of items and do things with it.

This Collection class:
 * is stateless,
 * extendable,
 * leverage the power of PHP generators and iterators,
 * doesn't depends or require any other library or framework. 

Except a few methods, most of methods are returning a new Collection object.

This library has been inspired by the [Laravel Support Package](https://github.com/illuminate/support) and [Lazy.js](http://danieltao.com/lazy.js/).

## Requirements

* PHP >= 7.1.3

## Installation

```composer require drupol/collection```

## Usage

```php
<?php

declare(strict_types = 1);

include 'vendor/autoload.php';

use drupol\collection\Collection;

// More examples...
$collection = Collection::with(['A', 'B', 'C', 'D', 'E']);

// Get the result as an array.
$collection
    ->all(); // ['A', 'B', 'C', 'D', 'E']

// Get the first item.
$collection
    ->first(); // A

// Append items.
$collection
    ->append('F', 'G', 'H')
    ->all(); // ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']

// Prepend items.
$collection
    ->prepend('1', '2', '3')
    ->all(); // ['1', '2', '3', 'A', 'B', 'C', 'D', 'E']

// Split a collection into chunks of a given size.
$collection
    ->chunk(2)
    ->map(function (Collection $collection) {return $collection->all();})
    ->all(); // [['A', 'B'], ['C', 'D'], ['E']]

// Merge items.
$collection
    ->merge([1, 2], [3, 4], [5, 6])
    ->all(); // ['A', 'B', 'C', 'D', 'E', 1, 2, 3, 4, 5, 6]

// Map data
$collection
    ->map(
        static function ($item, $key) {
            return sprintf('%s.%s', $item, $item);
        }
    )
    ->all(); // ['A.A', 'B.B', 'C.C', 'D.D', 'E.E']

// ::map() and ::walk() are not the same.
Collection::with(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'])
    ->map(static function ($item, $key) {return strtolower($item); })
    ->all(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 = >'d', 4 => 'e']

Collection::with(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'])
    ->walk(static function ($item, $key) {return strtolower($item); })
    ->all(); // ['A' => 'a', B => 'b', 'C' => 'c', 'D' = >'d', 'E' => 'e']

// Infinitely loop over numbers, square them, filter those that are not divisible by 5, take the first 100 of them.
Collection::range(0, INF)
    ->map(static function ($number) {
        return $number ** 2;
    })
    ->filter(static function ($number) {
        return $number % 5;
    })
    ->limit(100)
    ->all(); // [1, 8, 27, ..., 1815848, 1860867, 1906624]

// Apply a callback to the values without altering the original object.
// If the callback returns false, then it will stop.
Collection::with(range('A', 'Z'))
    ->apply(static function ($item, $key) {
        echo strtolower($item);
    });

// The famous Fibonacci example:
Collection::with(
        static function($start = 0, $inc = 1) {
            yield $start;

            while(true)
            {
                $inc = $start + $inc;
                $start = $inc - $start;
                yield $start;
            }
        }

    )
    ->limit(10)
    ->all(); // [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]
```

## Advanced usage

Each operation of the Collection class live in its own class.

If you want to extend the collection features, you can use your own custom operation by creating a class implementing
the `drupol\Collection\Contract\Operation` interface, then run it through the `Collection::run()` method.

```php
<?php

declare(strict_types = 1);

include 'vendor/autoload.php';

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;
use drupol\collection\Operation\Operation;

$square = new class() extends Operation {
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        return $collection::withClosure(
            static function () use ($collection) {
                foreach ($collection as $item) {
                    yield $item ** 2;
                }
            }
        );
    }
};

Collection::range(5, 15)
    ->run($square)
    ->all(); // [25, 36, 49, 64, 81, 100, 121, 144, 169, 196]
```

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Travis CI](https://travis-ci.org/drupol/collection/builds) run the tests and the benchmarks.

The library has tests written with [PHPSpec](http://www.phpspec.net/).
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

[PHPInfection](https://github.com/infection/infection) is used to ensure that your code is properly tested, run `composer infection` to test your code.

## Contributing

Feel free to contribute to this library by sending Github pull requests. I'm quite reactive :-)
