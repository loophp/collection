Principles
==========

This section describes a few elements which are at the core of ``Collection``, 
and provides guidance on how to get the most out of the package.

Immutability
------------

Most :ref:`operations <Methods (operations)>` return a new collection object
rather than modifying the original one. 

Immutability usually makes your code:

* simpler to use, reason about, and test
* easier to debug
* more robust and consistent

A few notable exceptions to this are methods which return scalar values like ``count``;
you can read more about them in the :ref:`operations background <Background>` section. 

Laziness
--------

``Collection`` is "lazy" by default. `Lazy evaluation`_, or call-by-need, is an evaluation
strategy which delays the evaluation of an expression until its value is really needed.

In Collection, the operations are executed on the input stream only when iterating over it
or when using very specific operation like ``all`` or ``squash``.

Behaviour
~~~~~~~~~

``Collection`` leverages PHP ``Generators`` and ``Closures`` to allow working with
large data sets while using as little memory as possible. Thanks to lazy evaluation,
we can even deal with potentially infinite data sets or streams of data - see the
:ref:`advanced usage <Advanced>` section for more examples.

.. code-block:: php

    $even = static fn(int $item): bool => $item % 2 === 0;
    $square = static fn(int $item): int => $item * $item;

    $collection = Collection::fromIterable(range(0, 5))
        ->filter($even)
        ->map($square); // $collection is still unchanged up to this point

    // We can use `all` to get the results as an array
    var_dump($collection->all()); // [0, 4, 16]

    // Even better, we can iterate over the collection directly
    foreach ($collection as $item) {
        var_dump($item); // will print 0, 4, 16
    }

Internals
~~~~~~~~~

The ``Collection`` object is assisted by a couple powerful components:

`ClosureIterator`_ - allows iterating over the collection object by creating 
a new PHP Generator each time iteration is started.

`AbstractOperation`_ and the `Operation Interface`_ - provide the blueprint
for collection operations, which are pure functions defined as final classes
with the `invoke`_ PHP magic method. Operations return a ``Closure`` which itself
returns an ``Iterator``; they can thus be used inside ``ClosureIterator`` to 
create new generators when needed.

Side-Effects
~~~~~~~~~~~~

``Collection`` is a helper for making transformations to input data sets.
Despite the fact that you can technically trigger side-effects in some operations
through a custom ``Closure``, it's better to avoid this type of usage and instead 
use the operations for their transformative effects (use the return values).

Exception handling is one scenario where you might find yourself wanting ``Collection``
to behave eagerly. If you want an exception to be thrown and handled in a specific function,
during an operation, rather than when the collection is later iterated on, you might find the 
:ref:`squash operation <Squash>` helpful.

TODO

- variadic parameters, logical OR
- tweaking behaviour via custom callbacks
- testing

.. _AbstractOperation: https://github.com/loophp/collection/blob/master/src/Operation/AbstractOperation.php
.. _ClosureIterator: https://github.com/loophp/collection/blob/master/src/Iterator/ClosureIterator.php
.. _invoke: https://www.php.net/manual/en/language.oop5.magic.php#object.invoke
.. _Lazy evaluation: https://en.wikipedia.org/wiki/Lazy_evaluation
.. _Operation Interface: https://github.com/loophp/collection/blob/master/src/Contract/Operation.php
