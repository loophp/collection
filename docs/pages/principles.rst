Principles
==========

This section describes a few elements which are at the core of ``Collection`` 
and guides on how to get the most out of the package.

Immutability
------------

Most :ref:`operations <Methods (operations)>` return a new collection object
rather than modifying the original one. 

Immutability usually makes our code:

* simpler to use, reason about, and test
* easier to debug
* more robust and consistent

A few notable exceptions to this are methods that return scalar values like ``count``;
read more about them in the :ref:`operations background <Background>` section. 

Laziness
--------

``Collection`` is "lazy" by default. `Lazy evaluation`_, or call-by-need, is an evaluation
strategy which delays the evaluation of an expression until its value is really needed.

Collection operations are executed on the input stream only when iterating over it,
or when using very specific operations like ``all`` or ``squash``.

Behavior
~~~~~~~~

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

The ``Collection`` object is assisted by a couple of powerful components:

`ClosureIterator`_ - allows iterating over the collection object by creating 
a new PHP Generator each time iteration is started.

`AbstractOperation`_ and the `Operation Interface`_ - provide the blueprint
for collection operations, which are pure functions defined as final classes
with the `invoke`_ PHP magic method. Operations return a ``Closure`` when called, 
which itself returns an ``Iterator``; they can thus be used inside ``ClosureIterator`` to 
create new generators when needed.

Side-Effects
~~~~~~~~~~~~

``Collection`` is a helper for making transformations to input data sets.
Even though we can technically trigger side-effects in some operations
through a custom ``Closure``, it's better to avoid this type of usage and instead 
use the operations for their transformative effects (use the return values).

Exception handling is one scenario where we might find ourselves wanting ``Collection``
to behave eagerly. If we want an exception to be thrown and handled in a specific function,
during an operation, rather than when the collection is later iterated on, we can take advantage 
of the :ref:`squash <Squash>` operation.

Testing
~~~~~~~

Working with lazy evaluation can impact how we test our code. Depending on the testing
framework used, we have a few options at our disposal when it comes to comparing collections
objects returned by a function.

``Collection`` already provides two operations which can be used for comparison:

* :ref:`Equals <Equals>` - allows usage of the `assertObjectEquals`_ assertion in *PHPUnit*
* :ref:`Same <Same>` - allows customizing precisely how elements are compared using a callback 

Note that these operations will traverse both collections as part of the comparison. As such,
any side effects triggered in our source code will be triggered during this comparison. When
using ``equals`` in particular, we might find it useful to apply ``squash`` to the resulting
collection object before the comparison if our test needs to assert how many times 
a side effect is performed. 

In addition to these, in *PHPSpec* we can use the `iterateAs`_ matcher to assert how our
final collection object will iterate.

The last option is to transform the collection object into an array with the :ref:`all <All>` operation
and use any assertion that we would normally use for arrays.

Usability
---------

``Collection`` and the ``Operations`` are designed with usability and flexibility in mind.
A few key elements that contribute to this are the usage of *variadic parameters*, *custom callbacks*,
and the fact that operations can be used both as collection object methods or *completely separately*.

Variadic Parameters
~~~~~~~~~~~~~~~~~~~

Variadic parameters are used wherever possible in operations, allowing us to more succintly apply
multiple transformations or predicates. They will *always* be evaluated by the operation as a *logical OR*.

For example, the :ref:`contains <Contains>` operation allows us to easily check whether one or more
values are contained in the collection:

.. literalinclude:: code/operations/contains.php
  :language: php

If we want to instead achieve a *logical AND* behaviour, we can make multiple calls to the same operation.
The following example using the :ref:`filter <Filter>` operation illustrates this:

.. literalinclude:: code/operations/filter.php
  :language: php

Custom Callbacks
~~~~~~~~~~~~~~~~

Many operations allow us to customize their behavior through custom callbacks. This gives us the power
to achieve what we need with the operation if the default behavior is not the best fit for our use case.

For example, by default the :ref:`same <Same>` operation will compare collection elements using 
strict equality (``===``). However, when dealing with objects we might want a different behavior:

.. code-block:: php

    $a = (object) ['id' => 'a'];
    $a2 = (object) ['id' => 'a'];

    $comparator = static fn (stdClass $left) => static fn (stdClass $right): bool => $left->id === $right->id;
    Collection::fromIterable([$a])
        ->same(Collection::fromIterable([$a2]), $comparator); // true

Independent Operations
~~~~~~~~~~~~~~~~~~~~~~

Operations are pure functions that can be used to transform an iterator, either directly or
through the ``Collection`` object.

For example, the :ref:`filter <Filter>` operation can be used on another iterator,
independently of the ``Collection`` object. Because all operations return an iterator at the end,
we can use `iterator_to_array`_ to convert this back to a normal array when needed.

.. literalinclude:: code/operations/background.php
  :language: php

.. _AbstractOperation: https://github.com/loophp/collection/blob/master/src/Operation/AbstractOperation.php
.. _assertObjectEquals: https://phpunit.readthedocs.io/en/9.5/assertions.html#assertobjectequals
.. _ClosureIterator: https://github.com/loophp/collection/blob/master/src/Iterator/ClosureIterator.php
.. _invoke: https://www.php.net/manual/en/language.oop5.magic.php#object.invoke
.. _iterator_to_array: https://www.php.net/manual/en/function.iterator-to-array.php
.. _iterateAs: https://www.phpspec.net/en/stable/cookbook/matchers.html#iterateas-matcher
.. _Lazy evaluation: https://en.wikipedia.org/wiki/Lazy_evaluation
.. _Operation Interface: https://github.com/loophp/collection/blob/master/src/Contract/Operation.php
