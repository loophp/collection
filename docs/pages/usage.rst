Usage
=====

Find here some working examples.

Simple
-------

.. literalinclude:: code/simple.php
  :language: php

Advanced
--------

Manipulate keys and values
~~~~~~~~~~~~~~~~~~~~~~~~~~

This example show the power of a lazy library and highlight also how to use
it in a wrong way.

Unlike regular PHP arrays where there can only be one key of type int or
string, a lazy library can have multiple times the same keys and they can
be of any type !

.. code-block:: bash

    // This following example is perfectly valid, despite that having array for keys
    // in a regular PHP arrays is impossible.
    $input = static function () {
        yield ['a'] => 'a';
        yield ['b'] => 'b';
        yield ['c'] => 'c';
    };
    Collection::fromIterable($input());

A lazy collection library can also have multiple times the same key.

Here we are going to make a frequency analysis on the text and see the
result. We can see that some data are missing, why ?

.. code-block:: bash

    $string = 'aaaaabbbbcccddddeeeee';

    $collection = Collection::fromIterable($string)
        // Run the frequency analysis tool.
        ->frequency()
        // Convert to regular array.
        ->all(); // [5 => 'e', 4 => 'd', 3 => 'c']

The reason that the frequency analysis for letters 'a' and 'b' are missing
is because when you call the method ->all(), the collection converts the
lazy collection into a regular PHP array, and PHP doesn't allow having
multiple time the same key, so it overrides the previous data and there are
missing information in the resulting array.

In order to circumvent this, you can either wrap the final result or
normalize it.
A better way would be to not convert this into an array and use the lazy
collection as an iterator.

Wrapping the result will wrap each result into a PHP array.
Normalizing the result will replace keys with a numerical index, but then
you might lose some information then.

It's up to you to decide which one you want to use.

.. code-block:: bash

    $collection = Collection::fromIterable($string)
        // Run the frequency analysis tool.
        ->frequency()
        // Wrap each result into an array.
        ->wrap()
        // Convert to regular array.
        ->all();
    /**
     * [
     *   [5 => 'a'],
     *   [4 => 'b'],
     *   [3 => 'c'],
     *   [4 => 'd'],
     *   [5 => 'e'],
     * ]
     */

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
