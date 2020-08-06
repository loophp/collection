Collection
==========

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
 * type safe (*type safe @ > 98%*),
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
 * `nikic/iter`_
 * `Lazy.js`_

.. _array_map(): https://www.php.net/array-map
.. _array_filter(): https://www.php.net/array-filter
.. _array_reduce(): https://www.php.net/array-reduce
.. _nikic/iter: https://github.com/nikic/iter
.. _DusanKasan/Knapsack: https://github.com/DusanKasan/Knapsack
.. _mtdowling/transducers: https://github.com/mtdowling/transducers.php
.. _Ruby Array: https://ruby-doc.org/core-2.7.0/Array.html
.. _Collect.js: https://collect.js.org
.. _new Collection object: https://github.com/loophp/collection/blob/master/src/Collection.php
.. _SplObjectStorage: https://www.php.net/manual/en/class.splobjectstorage.php
.. _this example: https://loophp-collection.readthedocs.io/en/latest/pages/examples.html#manipulate-keys-and-values
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

.. toctree::
    :hidden:

    Collection <self>

.. toctree::
   :hidden:
   :caption: Table of Contents

   Requirements <pages/requirements>
   Installation <pages/installation>
   Usage <pages/usage>
   Examples <pages/examples>
   API <pages/api>
   Tests <pages/tests>
   Contributing <pages/contributing>
