PHP Collection
==============

Collection is a functional utility library for PHP greater than 7.1.3.

It's similar to `other available collection libraries`_ based on regular PHP arrays,
but with a lazy mechanism under the hood that strives to do as little work as possible while being as flexible
as possible.

Functions like `array_map()`_, `array_filter()`_ and `array_reduce()`_ are great, but they create new arrays and
everything is eagerly done before going to the next step.
Lazy collection leverages PHP's generators, iterators and yield statements to allow you to work with very large data
sets while keeping memory usage as low as possible.

For example, imagine your application needs to process a multi-gigabyte log file while taking advantage of this
library's methods to parse the logs.
Instead of reading the entire file into memory at once, this library may be used to keep only a small part of the file
in memory at a given time.

On top of this, this library:

 * is `immutable`_,
 * is extendable,
 * leverages the power of PHP `generators`_ and `iterators`_,
 * uses `S.O.L.I.D. principles`_,
 * does not have any external dependency,
 * fully tested,
 * type safe (*type safe @ > 95%*),
 * framework agnostic.

Except a few methods, most methods are `pure`_ and return a `new Collection object`_.

Also, unlike regular PHP arrays where keys must be either of type `int` or `string`, this collection library let you use
any kind of type for keys: integer, string, objects, arrays, ... anything!
This library could be a valid replacement for `\SplObjectStorage`_ but with much more features.
This way of working opens up new perspectives and another way of handling data, in a more functional way.

And last but not least, collection keys are preserved throughout most operations, and it might be leading to some
confusions, carefully read `this example`_ for the full explanation.

This library has been inspired by:

 * `Laravel Support Package`_
 * `DusanKasan/Knapsack`_
 * `mtdowling/transducers`_
 * `Ruby Array`_
 * `Collect.js`_
 * `Rambda`_
 * `nikic/iter`_
 * `Haskell`_
 * `Lazy.js`_

Features
--------

-  **Decoupled**: Each Collection methods is a shortcut to one isolated
   standard class, each operation has its own responsibility. Usually
   the arguments needed are standard PHP variables like ``int``,
   ``string``, ``callable`` or ``iterator``. It allows users to use
   those operations individually, at their own will to build up
   something custom. Currently, more than :ref:`80 operations <api>`
   are available in this library. This library is basically an
   example of what you can do with all those small bricks, but nothing
   prevent users to use an operation on its own as well.

-  **It takes function first, data-last**: In the following example,
   multiple operations are created. The data to be operated on is
   generally supplied at last.

   .. code:: php

      <?php

      $data = ['foo', 'bar', 'baz'];
      $filterCallback = static fn(string $userId): bool => 'foo' !== $userId;

      // Using the Collection library
      $collection = Collection::fromIterable($data)
          ->filter($filterCallback)
          ->reverse();
      print_r($collection->all()); // ['baz', 'bar']

      // Using single operations.
      $filter = Filter::of()($filterCallback);
      $reverse = Reverse::of();
      $pipe = Pipe::of()($reverse, $filter);

      print_r(iterator_to_array($pipe(new ArrayIterator($data))));  // ['baz', 'bar']

   More information about this in the `Brian Lonsdorf's conference`_, 
   even if this is for Javascript, 
   those concepts are common to other programming languages.

   In a nutshell, the combination of currying and function-first enables
   the developer to compose functions with very little code (*often in a
   “point-free” fashion*), before finally passing in the relevant user
   data.

-  **Operations are stateless and curried by default**: This currying
   makes it easy to compose functions to create new functions. Because
   the API is *function-first*, *data-last*, you can continue composing
   and composing until you build up the function you need before
   dropping in the data. See `this Hugh Jackson article`_ describing 
   the advantages of this style.

   In the following example, the well-known `flatMap`_ could
   be composed of other operations as such:

   .. code:: php

      <?php

      $input = ['foo,bar', 'baz,john'];
      $userData = new ArrayIterator($input);

      $flatMap = static fn (callable $callable) =>
                     Pipe::of()(
                        Map::of()($callable),
                        Flatten::of()(1),
                        Normalize::of()
                     );

      $callback = fn(string $name): array => explode(',', $name);

      print_r(iterator_to_array($flatMap($callback)($userData))); // ['foo', 'bar', 'baz', 'john']


On the internet
---------------

 * `Reddit announcement thread`_
 * `Reddit release 2.0.0 thread`_
 * `Featured in PHPStorm Annotated August 2020`_

Changelog
---------

See `CHANGELOG.md`_ for a changelog based on `git commits`_.

For more detailed changelogs, please check `the release changelogs`_.

.. _array_map(): https://www.php.net/array-map
.. _array_filter(): https://www.php.net/array-filter
.. _array_reduce(): https://www.php.net/array-reduce
.. _nikic/iter: https://github.com/nikic/iter
.. _DusanKasan/Knapsack: https://github.com/DusanKasan/Knapsack
.. _mtdowling/transducers: https://github.com/mtdowling/transducers.php
.. _Ruby Array: https://ruby-doc.org/core-2.7.0/Array.html
.. _Collect.js: https://collect.js.org
.. _Rambda: https://ramdajs.com/
.. _Haskell: https://www.haskell.org/
.. _new Collection object: https://github.com/loophp/collection/blob/master/src/Collection.php
.. _SplObjectStorage: https://www.php.net/manual/en/class.splobjectstorage.php
.. _this example: https://loophp-collection.readthedocs.io/en/latest/pages/usage.html#manipulate-keys-and-values
.. _Lazy.js: http://danieltao.com/lazy.js/
.. _Laravel Support Package: https://github.com/illuminate/support
.. _pure: https://en.wikipedia.org/wiki/Pure_function
.. _S.O.L.I.D. principles: https://en.wikipedia.org/wiki/SOLID
.. _iterators: https://www.php.net/manual/en/class.iterator.php
.. _generators: https://www.php.net/manual/en/class.generator.php
.. _immutable: https://en.wikipedia.org/wiki/Immutable_object
.. _other available collection libraries: https://packagist.org/?query=collection
.. _PHP Standards Recommendations: https://www.php-fig.org/
.. _PSR-4: https://www.php-fig.org/psr/psr-4/
.. _PSR-12: https://www.php-fig.org/psr/psr-12/
.. _Ruby arrays: https://apidock.com/ruby/Array
.. _Brian Lonsdorf's conference: https://www.youtube.com/watch?v=m3svKOdZijA
.. _this Hugh Jackson article: http://hughfdjackson.com/javascript/why-curry-helps/
.. _flatMap: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/flatMap
.. _Reddit announcement thread: https://www.reddit.com/r/PHP/comments/csxw23/a_stateless_and_modular_collection_class/
.. _Reddit release 2.0.0 thread: https://www.reddit.com/r/PHP/comments/i2u2le/release_of_version_200_of_loophpcollection/
.. _Featured in PHPStorm Annotated August 2020: https://blog.jetbrains.com/phpstorm/2020/08/php-annotated-august-2020/
.. _CHANGELOG.md: https://github.com/loophp/collection/blob/master/CHANGELOG.md
.. _git commits: https://github.com/loophp/collection/commits/master
.. _the release changelogs: https://github.com/loophp/collection/releases

.. toctree::
    :hidden:

    Collection <self>

.. toctree::
   :hidden:
   :caption: Table of Contents

   Requirements <pages/requirements>
   Installation <pages/installation>
   Usage <pages/usage>
   API <pages/api>
   Tests <pages/tests>
   Contributing <pages/contributing>
