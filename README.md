[![Latest Stable Version](https://img.shields.io/packagist/v/loophp/collection.svg?style=flat-square)](https://packagist.org/packages/loophp/collection)
 [![GitHub stars](https://img.shields.io/github/stars/loophp/collection.svg?style=flat-square)](https://packagist.org/packages/loophp/collection)
 [![Total Downloads](https://img.shields.io/packagist/dt/loophp/collection.svg?style=flat-square)](https://packagist.org/packages/loophp/collection)
 [![GitHub Workflow Status](https://img.shields.io/github/workflow/status/loophp/collection/Continuous%20Integration?style=flat-square)](https://github.com/loophp/collection/actions)
 [![Scrutinizer code quality](https://img.shields.io/scrutinizer/quality/g/loophp/collection/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/loophp/collection/?branch=master)
 [![Type Coverage](https://shepherd.dev/github/loophp/collection/coverage.svg)](https://shepherd.dev/github/loophp/collection)
 [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/loophp/collection/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/loophp/collection/?branch=master)
 [![License](https://img.shields.io/packagist/l/loophp/collection.svg?style=flat-square)](https://packagist.org/packages/loophp/collection)
 [![Donate!](https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square)](https://github.com/sponsors/drupol)
 
# PHP Collection

## Description

Collection is a functional utility library for PHP greater than 7.2.5.

It's similar to [other collection libraries](https://packagist.org/?query=collection) based on regular PHP arrays,
but with a lazy mechanism under the hood that strives to do as little work as possible while being as flexible
as possible.

Collection leverages PHP's generators, iterators and yield statements to allow you to work with very large data sets
while keeping memory usage as low as possible.

For example, imagine your application needs to process a multi-gigabyte log file while taking advantage of this
library's methods to parse the file.
Instead of reading and storing the entire file into memory at once, this library may be used to keep only a small part
of the file in memory at a given time.

On top of this, this library:
 * is [immutable](https://en.wikipedia.org/wiki/Immutable_object),
 * is extendable,
 * leverages the power of PHP [generators](https://www.php.net/manual/en/class.generator.php) and [iterators](https://www.php.net/manual/en/class.iterator.php),
 * uses [S.O.L.I.D. principles](https://en.wikipedia.org/wiki/SOLID),
 * does not have any external dependency,
 * fully tested,
 * framework agnostic.
 
Except a few methods, most methods are [pure](https://en.wikipedia.org/wiki/Pure_function) and return a
[new Collection object](https://github.com/loophp/collection/blob/master/src/Collection.php).

This library has been inspired by:
* [Laravel Support Package](https://github.com/illuminate/support)
* [Lazy.js](http://danieltao.com/lazy.js/)
* [Ruby Array](https://ruby-doc.org/core-2.7.0/Array.html)
* [mtdowling/transducers](https://github.com/mtdowling/transducers.php)

Similar libraries:
* [DusanKasan/Knapsack](https://github.com/DusanKasan/Knapsack)
* [nikic/iter](https://github.com/nikic/iter)

## Installation

```composer require loophp/collection```

## Documentation

On top of a complete documented code, the package include a full documentation that gets automatically compiled
and published upon each commit at [https://loophp-collection.rtfd.io](https://loophp-collection.rtfd.io).

The documentation is missing some parts, it's being continuously improved with time.

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Github](https://github.com/loophp/collection/actions) run the
tests.

The library has tests written with [PHPSpec](http://www.phpspec.net/).
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

Before each commit some inspections are executed with [GrumPHP](https://github.com/phpro/grumphp), 
run `./vendor/bin/grumphp run` to check manually.

[PHPInfection](https://github.com/infection/infection) is used to ensure that your code is properly tested, run `composer infection` to test your code.

## Contributing

Feel free to contribute to this library by sending Github pull requests. I'm quite reactive :-)

## On the internet
* [Reddit announcement thread](https://www.reddit.com/r/PHP/comments/csxw23/a_stateless_and_modular_collection_class/)
