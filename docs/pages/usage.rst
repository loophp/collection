Usage
=====

Find here some working examples.

.. tip:: Read the section on :ref:`Working with keys and values` to better
    understand the differences between working with Collection compared to
    normal PHP arrays.
    The same principles apply to all :ref:`API methods <Methods (operations)>`,
    giving you great power to manipulate various types of data if used
    correctly.

Simple
------

.. literalinclude:: code/simple.php
  :language: php

Advanced
--------

Working with keys and values
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This example shows the power of a lazy library and highlight also how to use
it in the wrong way.

Unlike regular PHP arrays where there can only be one key of type int or
string, a lazy library can have multiple times the same keys and they can
be of any type!

.. code-block:: php

    // This following example is perfectly valid, despite that having array for
    // keys in a regular PHP arrays is impossible.
    $input = static function () {
        yield ['a'] => 'a';
        yield ['b'] => 'b';
        yield ['c'] => 'c';
    };
    Collection::fromIterable($input());

A lazy collection library can also have multiple times the same key.

Here we are going to make a frequency analysis on the text and see the
result. We can see that some data is missing, why?

.. code-block:: php

    $string = 'aaaaabbbbcccddddeeeee';

    $collection = Collection::fromString($string)
        // Run the frequency analysis tool.
        ->frequency()
        // Convert to regular array.
        ->all(false); // [5 => 'e', 4 => 'd', 3 => 'c']

The reason that the frequency analysis for letters 'a' and 'b' is missing
is because when you call the method ``Collection::all()`` with a *false*
parameter, the collection converts the lazy collection into a regular PHP array,
and PHP doesn't allow having multiple time the same key; thus, it overrides
the previous data and there will be missing information in the resulting array.

In order to prevent this, by default the ``all`` operation will also apply
``normalize``, re-indexing and re-ordering the keys. However, this might not
always be the desired outcome, like in this instance (see examples below).

Other ways to circumvent this PHP array limitation:

* use the ``wrap`` operation on the final result, wrapping each key-value pair in a PHP array
* do not convert the collection to an array and use it as an iterator instead

It's up to you to decide which approach to take based on your use case.

.. literalinclude:: code/duplicate-keys.php
  :language: php

Serialization
~~~~~~~~~~~~~

The collection object implements the `JsonSerializable`_ interface, thus
allowing for JSON serialization using the built-in PHP function ``json_encode``
or a custom serializer like the `Symfony Serializer`_.

.. tip:: By default the collection is not normalized when serializing, which
        allows its usage as an associative array. However, when it is used as a
        list and there are missing keys, the ``normalize`` operation should be
        applied before serialization; not doing so will likely not result in the
        desired outcome, as shown in the example below.

.. literalinclude:: code/serialization.php
  :language: php

Extending collection
~~~~~~~~~~~~~~~~~~~~

Sometimes, it is possible that the feature set provided by this library is not
enough.

Then, you would like to create your own collection class with some specific
feature added on top of it.

Every classes of this library are ``final`` and then it is impossible to use
inheritance and use the original Collection class as parent of another one.

If you want to **extend** the Collection, you must use the Composition pattern.

You can read more about Inheritance and Composition by doing a query on your
favorite search engine. I also wrote an `article`_ about this.

Find here an example on how you could extend the collection class and add a
new Operation ``foobar``.

.. literalinclude:: code/extending-collection.php
  :language: php

Manipulate strings
~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/string.php
  :language: php

Random number generation
~~~~~~~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/random-generator.php
  :language: php

Approximate the number e
~~~~~~~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/e.php
  :language: php

Approximate the number Pi
~~~~~~~~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/monte-carlo.php
  :language: php

Approximate the golden ratio
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/goldenNumber.php
  :language: php

Fibonacci sequence
~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/fibonacci.php
  :language: php

Gamma function
~~~~~~~~~~~~~~

.. literalinclude:: code/gamma.php
  :language: php

Prime numbers
~~~~~~~~~~~~~

.. literalinclude:: code/primes.php
  :language: php

Text analysis
~~~~~~~~~~~~~

.. literalinclude:: code/text-analysis.php
  :language: php

Random number distribution
~~~~~~~~~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/random-numbers-distribution.php
  :language: php

Parse git log
~~~~~~~~~~~~~

.. literalinclude:: code/parse-git-log.php
  :language: php

Collatz conjecture
~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/collatz-conjecture.php
  :language: php

Read a file
~~~~~~~~~~~

.. literalinclude:: code/read-file.php
  :language: php

Lazy json parsing
~~~~~~~~~~~~~~~~~

.. literalinclude:: code/lazy-json-parsing.php
  :language: php

Calcultate N-Grams
~~~~~~~~~~~~~~~~~~

.. literalinclude:: code/ngrams.php
  :language: php

.. _article: https://not-a-number.io/2019/php-composition-and-inheritance/
.. _JsonSerializable: https://www.php.net/manual/en/class.jsonserializable.php
.. _Symfony Serializer: https://symfony.com/doc/current/components/serializer.html
