[![Latest Stable Version][latest stable version]][packagist collection]
 [![GitHub stars][github stars]][packagist collection]
 [![Total Downloads][total downloads]][packagist collection]
 [![GitHub Workflow Status][github workflow status]][collection actions]
 [![Scrutinizer code quality][code quality]][scrutinizer code quality]
 [![Type Coverage][type coverage]][sheperd type coverage]
 [![Code Coverage][code coverage]][scrutinizer code quality]
 [![License][license]][packagist collection]
 [![Donate!][donate github]][github sponsor]
 [![Donate!][donate paypal]][paypal sponsor]
 
# PHP Collection

## Description

Collection is a functional utility library for PHP greater than 7.1.3.

It's similar to [other collection libraries][Other collection libraries] based on regular PHP arrays,
but with a lazy mechanism under the hood that strives to do as little work as possible while being as flexible
as possible.

Functions like [`array_map()`][array_map function], [`array_filter()`][array_filter function] and
[`array_reduce()`][array_reduce function] are great, but they create new arrays and everything is eagerly done before
going to the next step.
Lazy collection leverages PHP's generators, iterators and yield statements to allow you to work with very large data
sets while keeping memory usage as low as possible.

For example, imagine your application needs to process a multi-gigabyte log file while taking advantage of this
library's methods to parse the file.
Instead of reading and storing the entire file into memory at once, this library may be used to keep only a small part
of the file in memory at a given time.

On top of this, this library:
 * is [immutable][immutable on wikipedia],
 * is extendable,
 * leverages the power of PHP [generators][php generators] and [iterators][php iterators],
 * uses [S.O.L.I.D. principles][solid on wikipedia],
 * does not have any external dependency,
 * fully tested,
 * type safe (_type safe @ > 98%_),
 * framework agnostic.
 
Except a few methods, most methods are [pure][pure function on wikipedia] and return a
[new Collection object][collection class].

Also, unlike regular PHP arrays where keys must be either of type `int` or `string`, this collection library let you use
any kind of type for keys: integer, string, objects, arrays, ... anything!
This library could be a valid replacement for [\SplObjectStorage][SplObjectStorage] but with much more features.
This way of working opens up new perspectives and another way of handling data, in a more functional way.

And last but not least, collection keys are preserved throughout most operations, and it might be leading to some
confusions, carefully read [this example][lazy collection example] for the full explanation.

This library has been inspired by:
* [Laravel Support Package][laravel support package]
* [DusanKasan/Knapsack][DusanKasan/Knapsack package]
* [mtdowling/transducers][mtdowling/transducers]
* [Ruby Array][ruby array]
* [Collect.js][collect.js]
* [nikic/iter][nikic/iter package]
* [Lazy.js][lazy.js]

## Installation

```composer require loophp/collection```

## Usage

Check out the [usage][collection usage] page, it contains trivial and more advanced use cases.

## Documentation

On top of a complete documented code, the package include a full documentation that gets automatically compiled
and published upon each commit at [https://loophp-collection.rtfd.io][collection documentation site].

[The API][collection api] will give you a pretty good idea of the
existing methods and what you can do with it.

I'm doing my best to keep the documentation up to date, if you found something odd, please let me know in the [issue
queue][collection issue queue].

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Github][collection actions] run the
tests.

The library has tests written with [PHPSpec][phpspec].
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

Before each commit some inspections (_currently 14_) are executed with [GrumPHP][grumphp], 
run `composer grumphp` to check manually.

The quality of the tests is tested with [Infection][infection] a PHP Mutation testing
framework,  run `composer infection` to try it.

Static analysers are also controlling the code. [PHPStan][phpstan] and
[PSalm][psalm] are enabled to their maximum level.

[PHP Insights][php insights] is also launched in Github actions just for
information. (_[example of PHP Insights report][php insights report], you must be logged on Github to see it_)

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite reactive :-)

If you can't contribute to the code, you can also sponsor me on [Github][github sponsor] or
[Paypal][paypal sponsor].

## On the internet
* [Reddit announcement thread][reddit announcement]
* [Reddit release 2.0.0 thread][reddit release 2.0.0]
* [Featured in PHPStorm Annotated August 2020][phpstorm annotated august 2020]

[packagist collection]: https://packagist.org/packages/loophp/collection
[latest stable version]: https://img.shields.io/packagist/v/loophp/collection.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/collection.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/collection.svg?style=flat-square
[github workflow status]: https://img.shields.io/github/workflow/status/loophp/collection/Continuous%20Integration?style=flat-square
[code quality]: https://img.shields.io/scrutinizer/quality/g/loophp/collection/master.svg?style=flat-square
[scrutinizer code quality]: https://scrutinizer-ci.com/g/loophp/collection/?branch=master
[type coverage]: https://shepherd.dev/github/loophp/collection/coverage.svg
[sheperd type coverage]: https://shepherd.dev/github/loophp/collection
[code coverage]: https://img.shields.io/scrutinizer/coverage/g/loophp/collection/master.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/collection.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[Other collection libraries]: https://packagist.org/?query=collection
[immutable on wikipedia]: https://en.wikipedia.org/wiki/Immutable_object
[php generators]: https://www.php.net/manual/en/class.generator.php
[php iterators]: https://www.php.net/manual/en/class.iterator.php
[solid on wikipedia]: https://en.wikipedia.org/wiki/SOLID
[pure function on wikipedia]: https://en.wikipedia.org/wiki/Pure_function
[collection class]: https://github.com/loophp/collection/blob/master/src/Collection.php
[array_map function]: https://www.php.net/array-map
[array_filter function]: https://www.php.net/array-filter
[array_reduce function]: https://www.php.net/array-reduce
[SplObjectStorage]: https://www.php.net/manual/en/class.splobjectstorage.php
[lazy collection example]: https://loophp-collection.readthedocs.io/en/latest/pages/examples.html#manipulate-keys-and-values
[laravel support package]: https://github.com/illuminate/support
[DusanKasan/Knapsack package]: https://github.com/DusanKasan/Knapsack
[mtdowling/transducers]: https://github.com/mtdowling/transducers.php
[ruby array]: https://ruby-doc.org/core-2.7.0/Array.html
[collect.js]: https://collect.js.org/
[nikic/iter package]: https://github.com/nikic/iter
[lazy.js]: http://danieltao.com/lazy.js/
[collection documentation site]: https://loophp-collection.rtfd.io
[collection api]: https://loophp-collection.readthedocs.io/en/latest/pages/api.html
[collection usage]: https://loophp-collection.readthedocs.io/en/latest/pages/usage.html
[collection examples]: https://loophp-collection.readthedocs.io/en/latest/pages/examples.html
[collection issue queue]: https://github.com/loophp/collection/issues
[collection actions]: https://github.com/loophp/collection/actions
[phpspec]: http://www.phpspec.net/
[grumphp]: https://github.com/phpro/grumphp
[infection]: https://github.com/infection/infection
[phpstan]: https://github.com/phpstan/phpstan
[psalm]: https://github.com/vimeo/psalm
[php insights]: https://packagist.org/packages/nunomaduro/phpinsights
[php insights report]: https://github.com/loophp/collection/runs/818917887?check_suite_focus=true#step:11:221
[github sponsor]: https://github.com/sponsors/drupol
[paypal sponsor]: https://www.paypal.me/drupol
[reddit announcement]: https://www.reddit.com/r/PHP/comments/csxw23/a_stateless_and_modular_collection_class/
[reddit release 2.0.0]: https://www.reddit.com/r/PHP/comments/i2u2le/release_of_version_200_of_loophpcollection/
[phpstorm annotated august 2020]: https://blog.jetbrains.com/phpstorm/2020/08/php-annotated-august-2020/