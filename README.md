[![Try!][phpsandbox image]][phpsandbox link]
[![Latest Stable Version][latest stable version]][packagist link]
[![GitHub stars][github stars]][packagist link]
[![Total Downloads][total downloads]][packagist link]
[![GitHub Workflow Status][github workflow status]][github actions link]
[![Scrutinizer code quality][code quality]][scrutinizer link]
[![Type Coverage][type coverage]][shepherd link]
[![Code Coverage][code coverage]][scrutinizer link]
[![Mutation testing badge][mutation badge url]][mutation badge link]
[![License][license]][packagist link]
[![Donate!][donate github]][github sponsors link]

# PHP Collection

## Description

Collection is a functional utility library for PHP greater than 7.4, including
PHP 8.0.

It's similar to [other collection libraries][7] based on regular PHP arrays, but
with a lazy mechanism under the hood that strives to do as little work as
possible while being as flexible as possible.

Functions like [`array_map()`][8], [`array_filter()`][9] and
[`array_reduce()`][10] are great, but they create new arrays and everything is
eagerly done before going to the next step. Lazy collection leverages PHP's
generators, iterators, and yield statements to allow you to work with very large
data sets while keeping memory usage as low as possible.

For example, imagine your application needs to process a multi-gigabyte log file
while taking advantage of this library's methods to parse the file. Instead of
reading and storing the entire file into memory at once, this library may be
used to keep only a small part of the file in memory at a given time.

On top of this, this library:

- is [immutable][11],
- is extendable,
- extensively uses [S.O.L.I.D. principles][14],
- leverages the power of PHP [generators][12] and [iterators][13],
- extensively tested,
- uses strict types,
- framework agnostic.

Except for a few methods, most methods are [pure][15] and return a [new
Collection object][16].

Also, unlike regular PHP arrays where keys must be either of type `int` or
`string`, this collection library lets you use any kind of type for keys:
`integer`, `string`, `object`, `array`, ... anything! This library could be a
valid replacement for [\SplObjectStorage][17] but with much more features. This
way of working opens up new perspectives and another way of handling data, in a
more functional way.

And last but not least, collection keys are preserved throughout most
operations; while it might lead to some confusion at first, please carefully
read [this example][18] for the full explanation and benefits.

This library has been inspired by:

- [Laravel Support Package][19]
- [DusanKasan/Knapsack][20]
- [mtdowling/transducers][21]
- [Ruby Array][22]
- [Collect.js][23]
- [nikic/iter][24]
- [Haskell][25]
- [Ramda][26]
- [Lazy.js][27]

## Features

- **Decoupled**: Each Collection method is a shortcut to one isolated standard
  class, each operation has its own responsibility. Usually, the arguments
  needed are standard PHP variables like `int`, `string`, `callable` or
  `iterator`. It allows users to use those operations individually, at their own
  will, to build up something custom. Currently, more than [**100
  operations**][28] are available in this library. This library is an example of
  what you can do with all those small bricks, but nothing prevents users from
  using an operation on its own as well.

- **It takes function first, data-last**: In the following example, multiple
  operations are created. The data to be operated on is generally supplied at
  last.

  ```php
  <?php

  $input = ['foo', 'bar', 'baz'];

  // Using the Collection library
  $collection = Collection::fromIterable($input)
      ->filter(static fn(string $userId): bool => 'foo' !== $userId)
      ->reverse();

  foreach ($collection as $item); // ['baz','bar']

  // Using single operations.
  $pipe = Pipe::of()(
    Reverse::of(),
    Filter::of()($filterCallback)
  );

  foreach ($pipe($input) as $item); // ['baz','bar']
  ```

  More information about this in the [Brian Lonsdorf's conference][29], even if
  this is for JavaScript, those concepts are common in other programming
  languages.

  In a nutshell, the combination of currying and function-first enables the
  developer to compose functions with very little code (_often in a “point-free”
  fashion_), before finally passing in the relevant user data.

- **Operations are stateless and curried by default**: This currying makes it
  easy to compose functions to create new functions. Because the API is
  _function-first_, _data-last_, you can continue composing and composing until
  you build up the function you need before dropping in the data. See [this Hugh
  Jackson article][30] describing the advantages of this style.

  In the following example, the well-known [`flatMap`][31] could be composed of
  other operations as such:

  ```php
  <?php

  $input = ['foo,bar', 'baz,john'];

  $flatMap = static fn (callable $callback) =>
    Pipe::of()(
        Map::of()(static fn(string $name): array => explode(',', $name)),
        Flatten::of()(1)
    );

  foreach ($flatMap($input) as $item); // ['foo', 'bar', 'baz', 'john']
  ```

## Installation

`composer require loophp/collection`

## Usage

Check out the [usage][32] page for both trivial and more advanced use cases.

## Dependencies

- [loophp/iterators][48]: A package providing PHP Iterators.

## Documentation

On top of well-documented code, the package includes a complete documentation
that gets automatically compiled and published upon each commit at
[https://loophp-collection.rtfd.io][33].

[The Collection Principles][47] will get you started with understanding the
elements that are at the core of this package, so you can get the most out of
its usage.

[The API][28] will give you a pretty good idea of the existing methods and what
you can do with them.

We are doing our best to keep the documentation up to date; if you found
something odd, please let us know in the [issue queue][34].

## Code quality, tests, benchmarks

Every time changes are introduced into the library,
[Github][github actions link] runs the tests.

The library has tests written with [PHPUnit][35]. Feel free to check them out in
the `tests/unit/` directory. Run `composer phpunit` to trigger the tests.

Before each commit, some inspections are executed with [GrumPHP][36]; run
`composer grumphp` to check manually.

The quality of the tests is tested with [Infection][37] a PHP Mutation testing
framework - run `composer infection` to try it.

Static analyzers are also controlling the code. [PHPStan][38] and [PSalm][39]
are enabled to their maximum level.

## Contributing

Feel free to contribute by sending pull requests. We are a usually very
responsive team and we will help you going through your pull request from the
beginning to the end, read more about it in the
[documentation][contributing doc page].

For some reasons, if you can't contribute to the code and willing to help,
sponsoring is a good, sound and safe way to show us some gratitude for the hours
we invested in this package.

Sponsor me on [Github][github sponsors link] and/or any of [the
contributors][6].

## On the internet

- [Reddit announcement thread][40]
- [Reddit release 2.0.0 thread][41]
- [Featured in PHPStorm Annotated August 2020][42]
- [Youtube presentation for AFUP Days 2021][46]

## Changelog

See [CHANGELOG.md][43] for a changelog based on [git commits][44].

For more detailed changelogs, please check [the release changelogs][45].

[phpsandbox image]:
  https://img.shields.io/badge/Try%20it-online%20!-brightgreen?style=flat-square
[phpsandbox link]: https://play.phpsandbox.io/loophp/collection
[packagist link]: https://packagist.org/packages/loophp/collection
[github actions link]: https://github.com/loophp/collection/actions
[scrutinizer link]:
  https://scrutinizer-ci.com/g/loophp/collection/?branch=master
[shepherd link]: https://shepherd.dev/github/loophp/collection
[github sponsors link]: https://github.com/sponsors/drupol
[latest stable version]:
  https://img.shields.io/packagist/v/loophp/collection.svg?style=flat-square
[github stars]:
  https://img.shields.io/github/stars/loophp/collection.svg?style=flat-square
[total downloads]:
  https://img.shields.io/packagist/dt/loophp/collection.svg?style=flat-square
[github workflow status]:
  https://img.shields.io/github/actions/workflow/status/loophp/collection/tests.yml?branch=master&style=flat-square
[code quality]:
  https://img.shields.io/scrutinizer/quality/g/loophp/collection/master.svg?style=flat-square
[type coverage]:
  https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Floophp%2Fcollection%2Fcoverage
[code coverage]:
  https://img.shields.io/scrutinizer/coverage/g/loophp/collection/master.svg?style=flat-square
[license]:
  https://img.shields.io/packagist/l/loophp/collection.svg?style=flat-square
[donate github]:
  https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]:
  https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[mutation badge url]:
  https://img.shields.io/endpoint?style=flat-square&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Floophp%2Fcollection%2Fmaster
[mutation badge link]:
  https://dashboard.stryker-mutator.io/reports/github.com/loophp/collection/master
[7]: https://packagist.org/?query=collection
[11]: https://en.wikipedia.org/wiki/Immutable_object
[12]: https://www.php.net/manual/en/class.generator.php
[13]: https://www.php.net/manual/en/class.iterator.php
[14]: https://en.wikipedia.org/wiki/SOLID
[15]: https://en.wikipedia.org/wiki/Pure_function
[16]: https://github.com/loophp/collection/blob/master/src/Collection.php
[8]: https://www.php.net/array-map
[9]: https://www.php.net/array-filter
[10]: https://www.php.net/array-reduce
[17]: https://www.php.net/manual/en/class.splobjectstorage.php
[18]:
  https://loophp-collection.readthedocs.io/en/stable/pages/usage.html#working-with-keys-and-values
[19]: https://github.com/illuminate/support
[20]: https://github.com/DusanKasan/Knapsack
[21]: https://github.com/mtdowling/transducers.php
[22]: https://ruby-doc.org/core-2.7.0/Array.html
[23]: https://collect.js.org/
[24]: https://github.com/nikic/iter
[27]: http://danieltao.com/lazy.js/
[33]: https://loophp-collection.rtfd.io
[28]: https://loophp-collection.readthedocs.io/en/stable/pages/api.html
[32]: https://loophp-collection.readthedocs.io/en/stable/pages/usage.html
[34]: https://github.com/loophp/collection/issues
[github actions link]: https://github.com/loophp/collection/actions
[35]: https://www.phpunit.de/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[6]: https://github.com/loophp/collection/graphs/contributors
[40]:
  https://www.reddit.com/r/PHP/comments/csxw23/a_stateless_and_modular_collection_class/
[41]:
  https://www.reddit.com/r/PHP/comments/i2u2le/release_of_version_200_of_loophpcollection/
[42]: https://blog.jetbrains.com/phpstorm/2020/08/php-annotated-august-2020/
[43]: https://github.com/loophp/collection/blob/master/CHANGELOG.md
[44]: https://github.com/loophp/collection/commits/master
[45]: https://github.com/loophp/collection/releases
[25]: https://www.haskell.org/
[29]: https://www.youtube.com/watch?v=m3svKOdZijA
[30]: http://hughfdjackson.com/javascript/why-curry-helps/
[26]: https://ramdajs.com/
[31]:
  https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/flatMap
[46]: https://www.youtube.com/watch?v=Kp47f8dtqoo
[47]: https://loophp-collection.readthedocs.io/en/stable/pages/principles.html
[48]: https://github.com/loophp/iterators
[contributing doc page]:
  https://loophp-collection.readthedocs.io/en/latest/pages/contributing.html
