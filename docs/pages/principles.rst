Principles
==========

This section describes a few elements which are at the core of ``Collection``, 
and provides guidance on how to get the most out of the package.

Immutability
------------

Most :ref:`operations <Methods (operations)>` return a new collection object
rather than modifying the original one. This makes your code easier to reason
about and more testable.

A few notable exceptions to this are methods which return scalar values like ``count``;
you can read more about them in the :ref:`operations background <Background>` section. 

Laziness
--------

Behaviour
~~~~~~~~~

``Collection`` leverages PHP ``Generators`` and ``Closures`` to allow working with
large data sets while using as little memory as possible. Operations benefit from
`lazy evaluation`_, which means that even using multiple methods in succession
will not have much impact on the program's runtime until the collection is iterated on, or
a dedicated operation such as ``all`` or ``squash`` is used.

This feature allows us to work even with potentially infinite data sets or streams of data.

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

Sometimes you might want your ``Collection`` object to behave eagerly.
This is a legitimate need when you want to trigger side-effects, like persisting
entities to a database or sending a batch of emails.

Aside from iterating over the collection object or a subset of it,
the :ref:`squash operation <Squash>` can be used to eagerly evaluate any
operations already applied. This can be used in conjunction with the :ref:`apply operation <Apply>`
to trigger side-effects using each item in the collection.

Another example showcased in the ``squash`` documentation is that of an exception
being thrown during an operation - if you want to trigger the exception in the method where
it's defined, you will find this operation useful.


TODO

- variadic parameters, logical OR
- tweaking behaviour via custom callbacks
- testing

.. _AbstractOperation: https://github.com/loophp/collection/blob/master/src/Operation/AbstractOperation.php
.. _ClosureIterator: https://github.com/loophp/collection/blob/master/src/Iterator/ClosureIterator.php
.. _invoke: https://www.php.net/manual/en/language.oop5.magic.php#object.invoke
.. _lazy evaluation: https://en.wikipedia.org/wiki/Lazy_evaluation
.. _Operation Interface: https://github.com/loophp/collection/blob/master/src/Contract/Operation.php
