Collection
==========

Collection is a functional utility library for PHP.

It's similar to `other available collection libraries`_ based on regular PHP arrays,
but with a lazy mechanism under the hood that strives to do as little work as possible while being as flexible
as possible.

Collection leverages PHP generators and iterators to allow you to work with very large data sets while keeping memory
usage as low as possible.

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
 * framework agnostic.

Except a few methods, most methods are `pure`_ and return a `new Collection object`_.

This library has been inspired by:
* `Laravel Support Package`_
* `Lazy.js`_
* `Ruby Array`_
* `mtdowling/transducers`_

Similar libraries:
* `DusanKasan/Knapsack`_
* `nikic/iter`_

It uses the following `PHP Standards Recommendations`_ :

-  `PSR-4`_ for classes auto loading,
-  `PSR-12`_ for coding standards.

.. _nikic/iter: https://github.com/nikic/iter
.. _DusanKasan/Knapsack: https://github.com/DusanKasan/Knapsack
.. _mtdowling/transducers: https://github.com/mtdowling/transducers.php
.. _Ruby Array: https://ruby-doc.org/core-2.7.0/Array.html
.. _new Collection object: https://github.com/loophp/collection/blob/master/src/Collection.php
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
