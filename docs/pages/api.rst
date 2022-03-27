.. _api:

API
===

Static constructors
-------------------

empty
~~~~~

Create an empty Collection.

Signature: ``Collection::empty(): Collection;``

.. code-block:: php

    $collection = Collection::empty();

fromCallable
~~~~~~~~~~~~

Create a collection from a callable.

.. tip:: This can be very useful when working with a PHP `Generator`_, since it will allow the collection
    object to behave as if the Generator was rewindable.

Signature: ``Collection::fromCallable(callable $callable, iterable $parameters = []): Collection;``

.. code-block:: php

    $callback = static function (): Generator {
        yield 'a';
        yield 'b';
        yield 'c';
    };

    $collection = Collection::fromCallable($callback);

fromFile
~~~~~~~~

Create a collection from a file.

Signature: ``Collection::fromIterable(string $filepath): Collection;``

.. code-block:: php

    Collection::fromFile('http://loripsum.net/api');

fromGenerator
~~~~~~~~~~~~~

Create a collection from a `Generator`_.

.. warning:: The difference between this constructor and ``fromIterable`` is that
    the generator is decorated with a caching Iterator. ``Generators`` are not
    **rewindable** by design and using ``fromGenerator`` automatically adds the
    caching layer for you.

.. tip:: You can reproduce the same behavior by using ``fromIterable`` directly
    followed by the ``cache`` operation.

Signature: ``Collection::fromGenerator(Generator $generator): Collection;``

.. code-block:: php

    $generator = (static fn () => yield from range(1, 5))();
    $generator->next();
    $generator->next();

    $collection = Collection::fromGenerator($generator)
        ->all(); // [0 => 3, 1 => 4, 2 => 5]

fromIterable
~~~~~~~~~~~~

Create a collection from an iterable.

.. warning:: When instantiating from a PHP `Generator`_, the collection object will inherit its behaviour:
    it will only be iterable a single time, and an exception will be thrown if multiple operations which attempt
    to re-iterate are applied, for example ``count()``. To circumvent this internal PHP limitation, use
    ``Collection::fromGenerator()`` or better ``Collection::fromCallable()`` which requires the generating
    callable not yet initialized.

Signature: ``Collection::fromIterable(iterable $iterable): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c']);

fromResource
~~~~~~~~~~~~

Create a collection from a resource.

Signature: ``Collection::fromResource($resource): Collection;``

.. code-block:: php

    $stream = fopen('data://text/plain,' . $string, 'rb');

    $collection = Collection::fromResource($stream);

fromString
~~~~~~~~~~

Create a collection from a string.

Signature: ``Collection::fromString(string $string, string $delimiter = ''): Collection;``

.. code-block:: php

    $data = file_get_contents('http://loripsum.net/api');

    $collection = Collection::fromString($data);

range
~~~~~

Build a collection from a range of values.

Signature: ``Collection::range(float $start = 0.0, float $end = INF, float $step = 1.0): Collection;``

.. code-block:: php

    $even = Collection::range(0, 20, 2); // [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20]

times
~~~~~

Create a collection by invoking a callback a given amount of times.

If no callback is provided, then it will create a simple list of incremented integers.

Signature: ``Collection::times(int $number = 0, ?callable $callback = null): Collection;``

.. code-block:: php

    $collection = Collection::times(5); // [1, 2, 3, 4, 5]

unfold
~~~~~~

Create a collection by yielding from a callback with an initial value.

.. warning:: The callback needs to return a list of values which will be reused as callback arguments
            on the next callback call. Therefore, the returned list should contain values of the same type
            as the parameters for the callback function.

Signature: ``Collection::unfold(callable $callback, ...$parameters): Collection;``

.. literalinclude:: code/operations/unfold.php
  :language: php

Methods (operations)
--------------------

Background
~~~~~~~~~~

Operations are pure functions which can be used to manipulate an iterator, either directly
or through the ``Collection`` object.

.. literalinclude:: code/operations/background.php
  :language: php

When used separately, operations typically return a PHP `Generator`_ or an `Iterator`_.
When used as a ``Collection`` method, operations fall into a few main categories based on the return type:

1. Operations that return a ``boolean`` or ``scalar`` value: ``Contains``, ``Count``, ``Equals``, ``Every``, ``Falsy``, ``Has``, ``IsEmpty``, ``Match`` (or ``MatchOne``), ``Nullsy``, ``Truthy``.

2. Operations that return a ``Collection`` of ``Collection`` objects: ``Partition``, ``Span``.

3. Operations that return keys/values from the collection: ``All``, ``Current``, ``Key``.

4. Operations that return a new ``Collection`` object: all other operations.

.. note:: The ``Key`` operation can return any value because ``Collection`` leverages PHP Generators,
        which allow using any type as a key as opposed to ``array``, which only allows ``int|string`` keys.

.. note:: Earlier versions of the package had most operations returning a new ``Collection`` object.
        This was changed based on convenience and ease of use; typical usage of operations which return ``boolean`` values
        would involve immediately retrieving the value inside, whereas for most other operations further transformations
        are likely to be applied.

all
~~~

Convert the collection into an array, re-indexing keys using ``Collection::normalize()`` to prevent data loss by default.

.. warning:: An earlier version of this operation did not re-index keys by default, which meant at times data loss could occur.
        The reason data loss could occur is because PHP array keys cannot be duplicated and must either be ``int`` or ``string``.
        The old behaviour can still be achieved by using the operation with the ``$normalize`` parameter as *false*.

Interface: `Allable`_

Signature: ``Collection::all(bool $normalize = true): array;``

.. literalinclude:: code/operations/all.php
  :language: php

append
~~~~~~

Add one or more items to a collection.

.. warning:: This operation maintains the keys of the appended items. If you wish to re-index the keys you can use the
            ``Collection::normalize()`` operation, or ``Collection::all()`` when converting into an array, which will apply
            ``normalize`` by default.

Interface: `Appendable`_

Signature: ``Collection::append(...$items): Collection;``

.. code-block:: php

    Collection::fromIterable([1 => '1', 2 => '2', 3 => '3'])
        ->append('4'); // [1 => '1', 2 => '2', 3 => '3', 0 => '4']

    Collection::fromIterable(['1', '2', '3'])
        ->append('4')
        ->append('5', '6')
        ->all(); // ['1', '2', '3', '4', '5', '6']

apply
~~~~~

Execute callback(s) on each element of the collection.

Iterates on the collection items regardless of the return value of the callback.

If the callback does not return ``true`` then it stops applying callbacks on subsequent items.

Interface: `Applyable`_

Signature: ``Collection::apply(callable ...$callbacks): Collection;``

.. literalinclude:: code/operations/apply.php
  :language: php

associate
~~~~~~~~~

Transform keys and values of the collection independently and combine them.

Interface: `Associateable`_

Signature: ``Collection::associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null): Collection;``

.. literalinclude:: code/operations/associate.php
  :language: php

asyncMap
~~~~~~~~

Asynchronously apply a single callback to every item of a collection and use the return value.

.. warning:: This method requires `amphp/parallel-functions <https://github.com/amphp/parallel-functions>`_ to be installed.

.. warning:: This operation is non-deterministic, we cannot ensure the order of the elements at the end. Additionally,
        keys are preserved - use the ``Collection::normalize`` operation if you want to re-index the keys.

.. warning:: An earlier version of this operation allowed usage with multiple callbacks. This behaviour
        was removed in version ``5.0``; ``asyncMapN`` should be used instead, or,
        alternatively, multiple successive ``asyncMap`` calls can achieve the same result.

Interface: `AsyncMapable`_

Signature: ``Collection::asyncMap(callable callback): Collection;``

.. code-block:: php

    $mapper = static function(int $value): int {
        sleep($value);

        return $value * 2;
    };

    $collection = Collection::fromIterable(['c' => 3, 'b' => 2, 'a' => 1])
        ->asyncMap($mapper); // ['a' => 2, 'b' => 4, 'c' => 6]

asyncMapN
~~~~~~~~~

Asynchronously apply one or more supplied callbacks to every item of a collection and use the return value.

.. tip:: This operation is best used when multiple callbacks need to be applied. If you only want to apply
        a single callback, ``asyncMap`` should be preferred as it benefits from more specific type hints.

.. warning:: This method requires `amphp/parallel-functions <https://github.com/amphp/parallel-functions>`_ to be installed.

.. warning:: This operation is non-deterministic, we cannot ensure the order of the elements at the end. Additionally,
        keys are preserved - use the ``Collection::normalize`` operation if you want to re-index the keys.

Interface: `AsyncMapNable`_

Signature: ``Collection::asyncMapN(callable ...$callbacks): Collection;``

.. code-block:: php

    $mapper1 = static function(int $value): int {
        sleep($value);

        return $value;
    };

    $mapper2 = static function(int $value): int {
        return $value * 2;
    };

    $collection = Collection::fromIterable(['c' => 3, 'b' => 2, 'a' => 1])
        ->asyncMapN($mapper1, $mapper2); // ['a' => 2, 'b' => 4, 'c' => 6]

averages
~~~~~~~~

Calculate the average of a collection of numbers.

The average constitute the result obtained by adding together several amounts
and then dividing this total by the number of amounts.

Based on `scanLeft1`, this operation will return the average at each iteration.
Therefore, if you're looking for one single result, you must get the last item
using `last` operation.

Interface: `Averagesable`_

Signature: ``Collection::averages(): Collection;``

.. literalinclude:: code/operations/averages.php
  :language: php

cache
~~~~~

Useful when using a resource as input and you need to run through the collection multiple times.

Interface: `Cacheable`_

Signature: ``Collection::cache(?CacheItemPoolInterface $cache = null): Collection;``

.. code-block:: php

    $fopen = fopen(__DIR__ . '/vendor/autoload.php', 'r');

    $collection = Collection::fromResource($fopen)
        ->cache();

chunk
~~~~~

Chunk a collection of items into chunks of items of a given size.

Interface: `Chunkable`_

Signature: ``Collection::chunk(int ...$sizes): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range(0, 6))
        ->chunk(2); // [[0, 1], [2, 3], [4, 5], [6]]

    $collection = Collection::fromIterable(range(0, 6))
        ->chunk(1, 2); // [[0], [1, 2], [3], [4, 5], [6]]

coalesce
~~~~~~~~

Return the first *non-nullsy* value in a collection.

*Nullsy* values are:

* The null value: ``null``
* Empty array: ``[]``
* The integer zero: ``0``
* The boolean: ``false``
* The empty string: ``''``

Interface: `Coalesceable`_

Signature: ``Collection::coalesce(): Collection;``

.. literalinclude:: code/operations/coalesce.php
  :language: php

collapse
~~~~~~~~

Collapse a collection of items into a simple flat collection.

.. warning:: Key differences compared to ``flatten`` are that only one level will be collapsed and values at the bottom level will be removed.

Interface: `Collapseable`_

Signature: ``Collection::collapse(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable([[1], [2, 3], [4, [5]]])
        ->collapse(); // [1, 2, 3, 4, [5]]

    $collection = Collection::fromIterable([1, 2, [3]])
        ->collapse(); // [3]

column
~~~~~~

Return the values from a single column in the input iterables.

.. tip:: If the iterables you are selecting from are ``Generators``, the operation will allow
         accessing keys of any type, not just ``int|string``.

Interface: `Columnable`_

Signature: ``Collection::column($column): Collection;``

.. code-block:: php

    $records = [
        [
            'id' => 2135,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ],
        [
            'id' => 3245,
            'first_name' => 'Sally',
            'last_name' => 'Smith',
        ],
        [
            'id' => 5342,
            'first_name' => 'Jane',
            'last_name' => 'Jones',
        ],
        [
            'id' => 5623,
            'first_name' => 'Peter',
            'last_name' => 'Doe',
        ],
    ];

    $result = Collection::fromIterable($records)
        ->column('first_name'); // ['John', 'Sally', 'Jane', 'Peter']

    $result = Collection::fromIterable($records)
        ->column('non_existent_key'); // []

combinate
~~~~~~~~~

Get all the `combinations <https://en.wikipedia.org/wiki/Combination>`_ of a given length of a collection of items.

Interface: `Combinateable`_

Signature: ``Collection::combinate(?int $length = null): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c'])
        ->combinate(2); // [['a', 'b'], ['b', 'c'], ['a', 'c']]

combine
~~~~~~~

Combine a collection of items with some other keys.

.. note:: When the two sets to combine are not equal in size, *null* is used as filling value.

Interface: `Combineable`_

Signature: ``Collection::combine(...$keys): Collection;``

.. literalinclude:: code/operations/combine.php
  :language: php

compact
~~~~~~~

Remove given values from the collection; if no values are provided, it removes *nullsy* values.

*Nullsy* values are:

* The null value: ``null``
* Empty array: ``[]``
* The integer zero: ``0``
* The boolean: ``false``
* The empty string: ``''``

Interface: `Compactable`_

Signature: ``Collection::compact(...$values): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 1 => 'b', null, false, 0, 'c'])
        ->compact(); // [0 => 'a', 1 => 'b', 5 => 'c']

    $collection = Collection::fromIterable(['a', 1 => 'b', null, false, 0, 'c'])
        ->compact(null, 0); // [0 => 'a', 1 => 'b', 3 => false, 5 => 'c']

contains
~~~~~~~~

Check if the collection contains one or more values.

.. warning:: The ``values`` parameter is variadic and will be evaluated as a logical ``OR``.

Interface: `Containsable`_

Signature: ``Collection::contains(...$values): bool;``

.. literalinclude:: code/operations/contains.php
  :language: php

count
~~~~~

Returns the number of elements in a collection.

.. tip:: If you only want to check whether the collection is empty or not, use the ``isEmpty``
         operation as it will be significant more performant in a large collection.

Interface: `Countable`_

Signature: ``Collection::count(): int;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'c'))
        ->count(); // 3

current
~~~~~~~

Get the value of an item in the collection given a numeric index or the default ``0``.

If the given numeric index is out of bound, current will return a default value ``null``
that can be modified by providing a second argument to the operation.

Interface: `Currentable`_

Signature: ``Collection::current(int $index = 0, $default = null);``

.. literalinclude:: code/operations/current.php
  :language: php

cycle
~~~~~

Cycle indefinitely around a collection of items.

Interface: `Cycleable`_

Signature: ``Collection::cycle(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd'])
        ->cycle();

diff
~~~~

Compares the collection against another collection, iterable, or set of multiple values.
This method will return the values in the original collection that are not present in the given argument set.

Interface: `Diffable`_

Signature: ``Collection::diff(...$values): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd', 'e'])
        ->diff('a', 'b', 'c', 'x'); // [3 => 'd', 4 => 'e']

diffKeys
~~~~~~~~

Compares the collection against another collection, iterable, or set of multiple keys.
This method will return the key / value pairs in the original collection that are not present in the given argument set.

Interface: `Diffkeysable`_

Signature: ``Collection::diffKeys(...$keys): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd', 'e'])
        ->diffKeys(1, 2); // [0 => 'a', 3 => 'd', 4 => 'e']

distinct
~~~~~~~~

Remove duplicated values from a collection, preserving keys.

The operation has 2 optional parameters that allow you to customize precisely
how values are accessed and compared to each other.

The first parameter is the comparator. This is a curried function which takes
first the left part, then the right part and then returns a boolean.

The second parameter is the accessor. This binary function takes the value and
the key of the current iterated value and then return the value to compare.
This is useful when you want to compare objects.

Interface: `Distinctable`_

Signature: ``Collection::distinct(?callable $comparatorCallback = null, ?callable $accessorCallback = null): Collection;``

.. literalinclude:: code/operations/distinct.php
  :language: php

drop
~~~~

Drop the first ``n`` items of the collection.

Interface: `Dropable`_

Signature: ``Collection::drop(int $count): Collection;``

.. code-block:: php

    Collection::fromIterable(range(10, 20))
        ->drop(2); // [12,13,14,15,16,17,18,19,20]

dropWhile
~~~~~~~~~

Iterate over the collection items and takes from it its elements from the moment when the condition fails for the
first time till the end of the list.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

Interface: `DropWhileable`_

Signature: ``Collection::dropWhile(callable ...$callbacks): Collection;``

.. code-block:: php

    $isSmallerThanThree = static function (int $value): bool {
        return 3 > $value;
    };

    Collection::fromIterable([1,2,3,4,5,6,7,8,9,1,2,3])
        ->dropWhile($isSmallerThanThree); // [3,4,5,6,7,8,9,1,2,3]

dump
~~~~

Dump one or multiple items. It uses `symfony/var-dumper`_ if it is available,
`var_dump()`_ otherwise. A custom ``callback`` can be also used.

Interface: `Dumpable`_

Signature: ``Collection::dump(string $name = '', int $size = 1, ?Closure $closure = null): Collection;``

.. code-block:: php

    Collection::fromIterable(range('a', 'e'))
        ->dump('Debug', 2); // Will debug the 2 first values.

duplicate
~~~~~~~~~

Find duplicated values from the collection.

The operation has 2 optional parameters that allow you to customize precisely
how values are accessed and compared to each other.

The first parameter is the comparator. This is a curried function which takes
first the left part, then the right part and then returns a boolean.

The second parameter is the accessor. This binary function takes the value and
the key of the current iterated value and then return the value to compare.
This is useful when you want to compare objects.

Interface: `Duplicateable`_

Signature: ``Collection::duplicate(?callable $comparatorCallback = null, ?callable $accessorCallback = null): Collection;``

.. literalinclude:: code/operations/duplicate.php
  :language: php

equals
~~~~~~

Compare two collections for equality. Collections are considered *equal* if:

* they have the same number of elements;
* they contain the same elements, regardless of the order they appear in or their keys.

Elements will be compared using strict equality (``===``). If you want to customize how elements
are compared or the order in which the keys/values appear is important, use the ``same`` operation.

.. tip:: This operation enables comparing ``Collection`` objects in PHPUnit tests using
    the dedicated `assertObjectEquals`_ assertion.

.. warning:: Because this operation *needs to traverse both collections* to determine if
    the same elements are contained within them, a performance cost is incurred. The operation will stop
    as soon as it encounters an element of one collection that cannot be found in the other. However,
    it is not recommended to use it for potentially large collections, where ``same`` can be used instead.

Interface: `Equalsable`_

Signature: ``Collection::equals(Collection $other): bool;``

.. literalinclude:: code/operations/equals.php
  :language: php

every
~~~~~

Check whether all elements in the collection pass the test implemented by the provided callback(s).

.. warning:: The ``callbacks`` parameter is variadic and will be evaluated as a logical ``OR``.

Interface: `Everyable`_

Signature: ``Collection::every(callable ...$callbacks): bool;``

.. code-block:: php

    $callback = static function (int $value): bool => $value < 20;

    $result = Collection::fromIterable(range(0, 10))
        ->every($callback); // true

    $result = Collection::fromIterable(range(0, 10))
        ->append(21)
        ->every($callback); // false

    $result = Collection::fromIterable([])
        ->every($callback); // true

explode
~~~~~~~

Explode a collection into subsets based on a given value.

This operation uses the ``split`` operation with the flag ``Splitable::REMOVE`` and thus, values used to explode the
collection are removed from the chunks.

Interface: `Explodeable`_

Signature: ``Collection::explode(...$explodes): Collection;``

.. code-block:: php

    $collection = Collection::fromString('I am a text.')
        ->explode(' '); // [['I', 'a', 'm', 'a', 't', 'e', 'x', 't', '.']]

falsy
~~~~~

Check if the collection contains *only falsy* values. A value is determined to be *falsy* by applying a ``bool`` cast.

Interface: `Falsyable`_

Signature: ``Collection::falsy(): bool;``

.. code-block:: php

    $result = Collection::fromIterable([2, 3, 4])
        ->falsy(); // false

    $result = Collection::fromIterable([2, null, 4])
        ->falsy(); // false

    $result = Collection::fromIterable(['', null, 0])
        ->falsy(); // true

filter
~~~~~~

Filter collection items based on one or more callbacks.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

.. tip:: It is only when the callback returns ``true`` that the value is kept.

.. tip:: If you're looking for keeping the value in the iterator when the return is ``false``, see the ``reject`` operation.

Interface: `Filterable`_

Signature: ``Collection::filter(callable ...$callbacks): Collection;``

.. literalinclude:: code/operations/filter.php
  :language: php

find
~~~~

Find a collection item using one or more callbacks. If the value cannot be found, that is, no callback returns true for
any collection item, it will return the ``$default`` value.

.. warning:: The ``callbacks`` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

.. tip:: This operation is a shortcut for ``filter`` + ``current``.

.. tip:: It is only when the callback returns ``true`` that the value is selected.

Interface: `Findable`_

Signature: ``Collection::find($default = null, callable ...$callbacks);``

.. literalinclude:: code/operations/find.php
  :language: php

first
~~~~~

Get the first item from the collection in a separate collection. Alias for ``head``.

The ``current`` operation can then be used to extract the item out of the collection.

Interface: `Firstable`_

Signature: ``Collection::first(): Collection;``

.. code-block:: php

        $generator = static function (): Generator {
            yield 'a' => 'a';
            yield 'b' => 'b';
            yield 'c' => 'c';
            yield 'a' => 'd';
            yield 'b' => 'e';
            yield 'c' => 'f';
        };

        Collection::fromIterable($generator())
            ->first()
            ->current(); // ['a' => 'a']

flatMap
~~~~~~~

Transform the collection using a callback and keep the return value, then flatten it one level.
The supplied callback needs to return an ``iterable``: either an ``array`` or a class that implements `Traversable`_.

.. tip:: This operation is nothing more than a shortcut for ``map`` + ``flatten(1)``, or ``map`` + ``unwrap``.

.. warning:: Keys are preserved, use the ``Collection::normalize`` operation if you want to re-index the keys.

Interface: `FlatMapable`_

Signature: ``Collection::flatMap(callable $callback): Collection;``

.. code-block:: php

    $square = static fn (int $val): int => $val ** 2;
    $squareArray = static fn (int $val): array => [$val ** 2];
    $squareCollection = static fn (int $val): Collection => Collection::fromIterable([$val ** 2]);

    $collection = Collection::fromIterable(range(1, 3))
        ->flatMap($squareArray); // [1, 4, 9]

    $collection = Collection::fromIterable(range(1, 3))
        ->flatMap($squareCollection); // [1, 4, 9]

    $collection = Collection::fromIterable(range(1, 3))
        ->map($square)
        ->flatten(1); // [1, 4, 9]

    $collection = Collection::fromIterable(range(1, 3))
        ->map($square)
        ->unwrap(); // [1, 4, 9]

flatten
~~~~~~~

Flatten a collection of items into a simple flat collection.

Interface: `Flattenable`_

Signature: ``Collection::flatten(int $depth = PHP_INT_MAX): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable([0, [1, 2], [3, [4, [5, 6]]]])
        ->flatten(); // [0, 1, 2, 3, 4, 5, 6]

    $collection = Collection::fromIterable([0, [1, 2], [3, [4, 5]])
        ->flatten(1); // [0, 1, 2, 3, [4, 5]]

flip
~~~~

Flip keys and items in a collection.

Interface: `Flipable`_

Signature: ``Collection::flip(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'a'])
        ->flip();

.. tip:: array_flip() and Collection::flip() can behave differently, check the following examples.

When using regular arrays, `array_flip()`_ can be used to remove duplicates (deduplicate an array).

.. code-block:: php

    $dedupArray = array_flip(array_flip(['a', 'b', 'c', 'd', 'a']));

This example will return ``['a', 'b', 'c', 'd']``.

However, when using a collection:

.. code-block:: php

    $dedupCollection = Collection::fromIterable(['a', 'b', 'c', 'd', 'a'])
        ->flip()
        ->flip()
        ->all();

This example will return ``['a', 'b', 'c', 'd', 'a']``.

foldLeft
~~~~~~~~

Takes the initial value and the first item of the list and applies the function
to them, then feeds the function with this result and the second argument and so
on. See ``scanLeft`` for intermediate results.

Interface: `FoldLeftable`_

Signature: ``Collection::foldLeft(callable $callback, $initial = null): Collection;``

.. code-block:: php

    Collection::fromIterable(range('A', 'C'))
        ->foldLeft(
            static function (string $carry, string $item): string {
                $carry .= $item;

                return $carry;
            },
            ''
        ); // [2 => 'ABC']

foldLeft1
~~~~~~~~~

Takes the first two items of the list and applies the function to them, then
feeds the function with this result and the third argument and so on.
See ``scanLeft1`` for intermediate results.

Interface: `FoldLeft1able`_

Signature: ``Collection::foldLeft1(callable $callback): Collection;``

.. code-block:: php

    $callback = static fn(int $carry, int $value): int => $carry - $value;

    Collection::fromIterable([64, 4, 2, 8])
        ->foldLeft1($callback); // [0 => 50]

    Collection::empty()
        ->foldLeft1($callback); // []

foldRight
~~~~~~~~~

Takes the initial value and the last item of the list and applies the function,
then it takes the penultimate item from the end and the result, and so on.
See ``scanRight`` for intermediate results.

Interface: `FoldRightable`_

Signature: ``Collection::foldRight(callable $callback, $initial = null): Collection;``

.. code-block:: php

    Collection::fromIterable(range('A', 'C'))
        ->foldLeft(
            static function (string $carry, string $item): string {
                $carry .= $item;

                return $carry;
            },
            ''
        ); // [0 => 'CBA']

foldRight1
~~~~~~~~~~

Takes the last two items of the list and applies the function, then it takes the
third item from the end and the result, and so on. See ``scanRight1`` for
intermediate results.

Interface: `FoldRight1able`_

Signature: ``Collection::foldRight1(callable $callback): Collection;``

.. code-block:: php

    $callback = static fn(int $carry, int $value): int => $carry + $value;

    Collection::fromIterable([1, 2, 3, 4])
        ->foldRight1($callback); // [0 => 10]

    Collection::empty()
        ->foldRight1($callback); // []

forget
~~~~~~

Remove items having specific keys.

Interface: `Forgetable`_

Signature: ``Collection::forget(...$keys): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'e'))
        ->forget(0, 4); // [1 => 'b', 2 => 'c', 3 => 'd']

frequency
~~~~~~~~~

Calculate the frequency of the items in the collection

Returns a new key-value collection with frequencies as keys.

Interface: `Frequencyable`_

Signature: ``Collection::frequency(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'b', 'c', 'c'])
        ->frequency()
        ->all(false); // [1 => 'a', 2 => 'b', 3 => 'c'];

get
~~~

Get a specific element of the collection from a key; if the key doesn't exist, returns the default value.

Interface: `Getable`_

Signature: ``Collection::get($key, $default = null): Collection;``

.. code-block:: php

    Collection::fromIterable(range('a', 'c'))->get(1) // [1 => 'b']

    Collection::fromIterable(range('a', 'c'))->get(4, '') // [0 => '']

group
~~~~~

Takes a list and returns a list of lists such that the concatenation of the result is equal to the argument.
Moreover, each sublist in the result contains only equal elements.

Interface: `Groupable`_

Signature: ``Collection::group(): Collection;``

.. code-block:: php

    Collection::fromString('Mississippi')
        ->group(); // [ [0 => 'M'], [1 => 'i'], [2 => 's', 3 => 's'], [4 => 'i'], [5 => 's', 6 => 's'], [7 => 'i'], [8 => 'p', 9 => 'p'], [10 => 'i'] ]

groupBy
~~~~~~~

Group items based on the provided callback.

Interface: `GroupByable`_

Signature: ``Collection::groupBy(callable $callback): Collection;``

.. code-block:: php

    $callback = static function () {
            yield 1 => 'a';
            yield 1 => 'b';
            yield 1 => 'c';
            yield 2 => 'd';
            yield 2 => 'e';
            yield 3 => 'f';
    };

    $collection = Collection::fromIterable($callback())
        ->groupBy(static fn (string $char, int $key): int => $key); // [1 => ['a', 'b', 'c'], 2 => ['d', 'e'], 3 => ['f']]

has
~~~

Check if the collection has values with the help of one or more callables.

.. warning:: The ``callbacks`` parameter is variadic and will be evaluated as a logical ``OR``.

Interface: `Hasable`_

Signature: ``Collection::has(callable ...$callbacks): bool;``

.. code-block:: php

    $result = Collection::fromIterable(range('A', 'C'))
        ->has(static fn (): string => 'B'); // true

    $result = Collection::fromIterable(range('A', 'C'))
        ->has(static fn (): string => 'D'); // false

    $result = Collection::fromIterable(range('A', 'C'))
        ->has(
            static fn ($value, $key): string => $key > 4 ? 'D' : 'A',
            static fn ($value, $key): string => 'Z'
        ); // true

head
~~~~

Get the first item from the collection in a separate collection. Same as ``first``.

The ``current`` operation can then be used to extract the item out of the collection.

Interface: `Headable`_

Signature: ``Collection::head(): Collection;``

.. code-block:: php

    $generator = static function (): Generator {
            yield 1 => 'a';
            yield 1 => 'b';
            yield 1 => 'c';
            yield 2 => 'd';
            yield 2 => 'e';
            yield 3 => 'f';
    };

    Collection::fromIterable($generator())
        ->head()
        ->current(); // [1 => 'a']

ifThenElse
~~~~~~~~~~

Execute a mapping callback on each item of the collection when a condition is met.

If no ``else`` callback is provided, the identity function is applied (elements are not modified).

Interface: `IfThenElseable`_

Signature: ``Collection::ifThenElse(callable $condition, callable $then, ?callable $else = null): Collection;``

.. code-block:: php

    $input = range(1, 5);

    $condition = static function (int $value): bool {
        return 0 === $value % 2;
    };

    $then = static function (int $value): int {
        return $value * $value;
    };

    $else = static function (int $value): int {
        return $value + 2;
    };

    Collection::fromIterable($input)
        ->ifThenElse($condition, $then); // [1, 4, 3, 16, 5]

    Collection::fromIterable($input)
        ->ifThenElse($condition, $then, $else) // [3, 4, 5, 16, 7]

implode
~~~~~~~

Join all the elements of the collection into a single string using a glue provided or the empty string as default.

.. tip:: Internally this operation uses ``foldLeft``, which is why the result will have the last element's key.

Interface: `Implodeable`_

Signature: ``Collection::implode(string $glue = ''): Collection;``

.. code-block:: php

    Collection::fromIterable(range('a', 'c'))
        ->implode('-'); // [2 => 'a-b-c']

init
~~~~

Returns the collection without its last item.

Interface: `Initable`_

Signature: ``Collection::init(): Collection;``

.. code-block:: php

    Collection::fromIterable(range('a', 'e'))
        ->init(); // ['a', 'b', 'c', 'd']

inits
~~~~~

Returns all initial segments of the collection, shortest first.

Interface: `Initsable`_

Signature: ``Collection::inits(): Collection;``

.. literalinclude:: code/operations/inits.php
  :language: php

intersect
~~~~~~~~~

Removes any values from the original collection that are not present in the given values set.

Interface: `Intersectable`_

Signature: ``Collection::intersect(...$values): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'e'))
        ->intersect('a', 'b', 'c'); // ['a', 'b', 'c']

intersectKeys
~~~~~~~~~~~~~

Removes any keys from the original collection that are not present in the given keys set.

Interface: `Intersectkeysable`_

Signature: ``Collection::intersectKeys(...$keys): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'e'))
        ->intersectKeys(0, 2, 4); // ['a', 'c', 'e']

intersperse
~~~~~~~~~~~

Insert a given value at every ``n`` element of a collection; indices are not preserved.

Interface: `Intersperseable`_

Signature: ``Collection::intersperse($element, int $every = 1, int $startAt = 0): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'c'))
        ->intersperse('x');

    foreach($collection as $item) {
        var_dump($item); // 'x', 'a', 'x', 'b', 'x', 'c'
    }

isEmpty
~~~~~~~

Check if a collection has any elements inside.

Interface: `IsEmptyable`_

Signature: ``Collection::isEmpty(): bool;``

.. literalinclude:: code/operations/isEmpty.php
  :language: php

jsonSerialize
~~~~~~~~~~~~~

Returns the collection items as an array, allowing serialization. Essentially calls ``all(false)``,
which means the collection is not normalized by default.

See the section on :ref:`serialization <Serialization>`.

Interface: `JsonSerializable`_

Signature: ``Collection::jsonSerialize(): array;``

.. literalinclude:: code/operations/jsonSerialize.php
  :language: php

key
~~~

Get the key of an item in the collection given a numeric index, default index is 0.

Interface: `Keyable`_

Signature: ``Collection::key(int $index = 0);``

.. code-block:: php

    Collection::fromIterable(['a', 'b', 'c', 'd'])->key(); // Return 0
    Collection::fromIterable(['a', 'b', 'c', 'd'])->key(0); // Return 0
    Collection::fromIterable(['a', 'b', 'c', 'd'])->key(1); // Return 1
    Collection::fromIterable(['a', 'b', 'c', 'd'])->key(10); // Return null

keys
~~~~

Get the keys of the items.

Interface: `Keysable`_

Signature: ``Collection::keys(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'd'))
        ->keys(); // [0, 1, 2, 3]

last
~~~~

Extract the last element of a collection, which must be finite and non-empty.

The ``current`` operation can then be used to extract the item out of the collection.

Interface: `Lastable`_

Signature: ``Collection::last(): Collection;``

.. code-block:: php

        $generator = static function (): Generator {
            yield 'a' => 'a';
            yield 'b' => 'b';
            yield 'c' => 'c';
            yield 'a' => 'd';
            yield 'b' => 'e';
            yield 'c' => 'f';
        };

        Collection::fromIterable($generator())
            ->last()
            ->current(); // ['c' => 'f']

limit
~~~~~

Limit the number of values in the collection.

Interface: `Limitable`_

Signature: ``Collection::limit(int count = -1, int $offset = 0): Collection;``

.. code-block:: php

    $even = Collection::range(0, \INF, 2)
        ->limit(5); // [0, 2, 4, 6, 8]

lines
~~~~~

Split a string into lines.

Interface: `Linesable`_

Signature: ``Collection::lines(): Collection;``

.. code-block:: php

    $string = <<<'EOF'
    The quick brown fox jumps over the lazy dog.

    This is another sentence.
    EOF;

    Collection::fromString($string)
        ->lines(); // ['The quick brown fox jumps over the lazy dog.', '', 'This is another sentence.']

map
~~~

Apply a single callback to every item of a collection and use the return value.

.. warning:: An earlier version of this operation allowed usage with multiple callbacks. This behaviour
        was removed in version ``5.0``; ``mapN`` should be used instead, or,
        alternatively, multiple successive ``map`` calls can achieve the same result.

.. warning:: Keys are preserved, use the ``Collection::normalize`` operation if you want to re-index the keys.

Interface: `Mapable`_

Signature: ``Collection::map(callable $callback): Collection;``

.. code-block:: php

    $square = static fn (int $val): int => $val ** 2;
    $toString = static fn (int $val): string => (string) $val;
    $appendBar = static fn (int $val): string => $val . 'bar';

    $collection = Collection::fromIterable(range(1, 3))
        ->map($square)
        ->map($toString)
        ->map($appendBar); // ['1bar', '4bar', '9bar']

mapN
~~~~

Apply one or more callbacks to every item of a collection and use the return value.

.. tip:: This operation is best used when multiple callbacks need to be applied. If you only want to apply
        a single callback, ``map`` should be prefered as it benefits from more specific type hints.

.. warning:: Keys are preserved, use the ``Collection::normalize`` operation if you want to re-index the keys.

Interface: `MapNable`_

Signature: ``Collection::mapN(callable ...$callbacks): Collection;``

.. code-block:: php

    $square = static fn (int $val): int => $val ** 2;
    $toString = static fn (int $val): string => (string) $val;
    $appendBar = static fn (int $val): string => $val . 'bar';

    $collection = Collection::fromIterable(range(1, 3))
        ->mapN($square, $toString, $appendBar); // ['1bar', '4bar', '9bar']

match
~~~~~

Check if the collection matches a given ``user callback``.

You must provide a callback that can get the ``key``, the ``current value``, and the ``iterator`` as parameters.

When no matcher callback is provided, the user callback must return ``true`` (the
default value of the ``matcher callback``) in order to stop.

The returned value of the operation is ``true`` when the callback matches at least one element
of the collection, ``false`` otherwise.

If you want to match the ``user callback`` against another value (other than ``true``), you must
provide your own ``matcher callback`` as a second argument, and it must return a ``boolean``.

Interface: `Matchable`_

Signature: ``Collection::match(callable $callback, ?callable $matcher = null): bool;``

.. literalinclude:: code/operations/match.php
  :language: php

matching
~~~~~~~~

Collection lets you use the Criteria API provided by `Doctrine Collections`_,
but in a lazy way.

Interface: `Matchingable`_

Signature: ``Collection::matching(Criteria $criteria): Collection;``

.. literalinclude:: code/operations/matching.php
  :language: php

merge
~~~~~

Merge one or more iterables onto a collection.

Interface: `Mergeable`_

Signature: ``Collection::merge(iterable ...$sources): Collection;``

.. code-block:: php

    Collection::fromIterable(range(1, 5))
        ->merge(range(6, 10)); // range(1, 10)

    $collection = Collection::fromIterable(['a', 'b', 'c'])
        ->merge(Collection::fromIterable(['d', 'e']);

    $collection->all() // ['a', 'b', 'c', 'd', 'e']

normalize
~~~~~~~~~

Replace, reorder and use numeric keys on a collection.

Interface: `Normalizeable`_

Signature: ``Collection::normalize(): Collection;``

.. literalinclude:: code/operations/normalize.php
  :language: php

nth
~~~

Get every n-th element of a collection.

Interface: `Nthable`_

Signature: ``Collection::nth(int $step, int $offset = 0): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range(1, 20))
        ->nth(5); // [0 => 1, 5 => 6, 10 => 11, 15 => 16]

nullsy
~~~~~~

Check if the collection contains *only nullsy* values.

*Nullsy* values are:

* The null value: ``null``
* Empty array: ``[]``
* The integer zero: ``0``
* The boolean: ``false``
* The empty string: ``''``

Interface: `Nullsyable`_

Signature: ``Collection::nullsy(): bool;``

.. code-block:: php

    $result = Collection::fromIterable([null, false])
        ->nullsy(); // true

    $result = Collection::fromIterable(['a', null, 'c'])
        ->nullsy(); // false

pack
~~~~

Wrap each item into an array containing 2 items: the key and the value.

Interface: `Packable`_

Signature: ``Collection::pack(): Collection;``

.. code-block:: php

    $input = ['a' => 'b', 'c' => 'd', 'e' => 'f'];

    $c = Collection::fromIterable($input)
        ->pack();

     // [
     //   ['a', 'b'],
     //   ['c', 'd'],
     //   ['e', 'f'],
     // ]

pad
~~~

Pad a collection to the given length with a given value.

Interface: `Padable`_

Signature: ``Collection::pad(int $size, $value): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range(1, 5))
        ->pad(8, 'foo'); // [1, 2, 3, 4, 5, 'foo', 'foo', 'foo']

pair
~~~~

Make an associative collection from pairs of values.

Interface: `Pairable`_

Signature: ``Collection::pair(): Collection;``

.. code-block:: php

    $input = [
        [
            'key' => 'k1',
            'value' => 'v1',
        ],
        [
            'key' => 'k2',
            'value' => 'v2',
        ],
        [
            'key' => 'k3',
            'value' => 'v3',
        ],
        [
            'key' => 'k4',
            'value' => 'v4',
        ],
        [
            'key' => 'k4',
            'value' => 'v5',
        ],
    ];

    $c = Collection::fromIterable($input)
        ->unwrap()
        ->pair();

    // [
    //    [k1] => v1
    //    [k2] => v2
    //    [k3] => v3
    //    [k4] => [
    //        [0] => v4
    //        [1] => v5
    //    ]
    // ]

partition
~~~~~~~~~

Partition the collection into two subgroups of items using one or more callables.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

The raw ``Partition`` operation returns a generator yielding two iterators.

The first inner iterator is the result of a ``filter`` operation, it contains items
that have met the provided callback(s).
The second (and last) inner iterator is the result of a ``reject`` operation, it contains items
that have not met the provided callback(s).

When the ``partition`` operation is used through the ``Collection`` object, the two
resulting iterators will be converted and mapped into a ``Collection`` object.

The first inner collection contains items that have met the provided callback(s).
The second (and last) collection contains items that have not met the provided callback(s).

Interface: `Partitionable`_

Signature: ``Collection::partition(callable ...$callbacks): Collection;``

.. literalinclude:: code/operations/partition.php
  :language: php

permutate
~~~~~~~~~

Find all the `permutations <https://en.wikipedia.org/wiki/Permutation>`_ of a collection.

Interface: `Permutateable`_

Signature: ``Collection::permutate(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b'])
        ->permutate(); // [['a', 'b'], ['b', 'a']]

pipe
~~~~

Pipe together multiple operations and apply them in succession to the collection items.
To maintain a lazy nature, each operation needs to return a ``Generator``.
Custom operations and operations provided in the API can be combined together.

Interface: `Pipeable`_

Signature: ``Collection::pipe(callable ...$callbacks): Collection;``

.. code-block:: php

    $square = static function ($collection): Generator {
        foreach ($collection as $item) {
            yield $item ** 2;
        }
    };

    $toString = static function ($collection): Generator {
        foreach ($collection as $item) {
            yield (string) $item;
        }
    };

    $times = new class() extends AbstractOperation {
        public function __invoke(): Closure
        {
            return static function ($collection): Generator {
                foreach ($collection as $item) {
                    yield "{$item}x";
                }
            };
        }
    };

    Collection::fromIterable(range(1, 5))
        ->pipe($square, Reverse::of(), $toString, $times())
        ->all(); // ['25x', '16x', '9x', '4x', '1x']

pluck
~~~~~

Retrieves all of the values of a collection for a given key.
Nested values can be retrieved using "dot notation" and the wildcard character ``*``.

Interface: `Pluckable`_

Signature: ``Collection::pluck($pluck, $default = null): Collection;``

.. literalinclude:: code/operations/pluck.php
  :language: php

prepend
~~~~~~~

Push an item onto the beginning of the collection.

.. warning:: This operation maintains the keys of the prepended items. If you wish to re-index the keys you can use the
            ``Collection::normalize()`` operation, or ``Collection::all()`` when converting into an array, which will apply
            ``normalize`` by default.

Interface: `Prependable`_

Signature: ``Collection::prepend(...$items): Collection;``

.. code-block:: php

    Collection::fromIterable([1 => '1', 2 => '2', 3 => '3'])
        ->prepend('4'); // [0 => 4, 1 => '1', 2 => '2', 3 => '3']

    Collection::fromIterable(['1', '2', '3'])
        ->prepend('4')
        ->prepend('5', '6')
        ->all(); // ['5', '6', '4', '1', '2', '3']

product
~~~~~~~

Get the `cartesian product <https://en.wikipedia.org/wiki/Cartesian_product>`_ of items of a collection.

Interface: `Productable`_

Signature: ``Collection::product(iterable ...$iterables): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('A', 'C'))
        ->product([1, 2]); // [['A', 1], ['A', 2], ['B', 1], ['B', 2], ['C', 1], ['C', 2]]

random
~~~~~~

Returns a random item from the collection.

An optional integer can be passed to random to specify how many items you would like to randomly retrieve.
An optional seed can be passed as well.

Interface: `Randomable`_

Signature: ``Collection::random(int $size = 1, ?int $seed = null): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->random(); // ['6']

reduce
~~~~~~

Reduce a collection of items through a given callback.

Interface: `Reduceable`_

Signature: ``Collection::reduce(callable $callback, $initial = null): Collection;``

.. literalinclude:: code/operations/reduce.php
  :language: php

reduction
~~~~~~~~~

Reduce a collection of items through a given callback and yield
each intermediary results.

Interface: `Reductionable`_

Signature: ``Collection::reduction(callable $callback, $initial = null): Collection;``

.. code-block:: php

    $callback = static fn ($carry, $item) => $carry + $item;

    $collection = Collection::fromIterable(range(1, 5))
        ->reduction($callback); // [1, 3, 6, 10, 15]

reject
~~~~~~

Reject collection items based on one or more callbacks.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation. However, due to the nature of this operation, the behaviour is the same.

.. tip:: It is only when the callback returns ``false`` that the value is kept.

.. tip:: If you're looking for keeping the value in the iterator when the return is ``true``, see the ``filter`` operation.

Interface: `Rejectable`_

Signature: ``Collection::reject(callable ...$callbacks): Collection;``

.. literalinclude:: code/operations/reject.php
  :language: php

reverse
~~~~~~~

Reverse the order of items in a collection.

Interface: `Reverseable`_

Signature: ``Collection::reverse(): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c'])
        ->reverse(); // ['c', 'b', 'a']

rsample
~~~~~~~

Take a random sample of elements of items from a collection. Accepts a probability parameter
which will influence the number of items sampled - higher probabilities increase the chance of
sampling close to the entire collection.

Interface: `RSampleable`_

Signature: ``Collection::rsample(float $probability): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range(1, 5));
    $collection->rsample(1.0); // [1, 2, 3, 4, 5]
    $collection->rsample(0.5); // will get about half of the elements at random

same
~~~~

Compare two collections for sameness. Collections are considered *same* if:

* they have the same number of elements;
* they have the same keys and elements, in the same order.

By default elements and keys will be compared using strict equality (``===``). However,
this behaviour can be customized with a comparator callback. This should be a curried function
which takes first the left value and key, then the right value and key, and returns a boolean.

This operation will stop and return a value as soon as one of the collections has been seen fully
or as soon as the comparison yields *false* for any key-value pair.

Interface: `Sameable`_

Signature: ``Collection::same(Collection $other, ?callable $comparatorCallback = null): bool;``

.. literalinclude:: code/operations/same.php
    :language: php

scale
~~~~~

Scale/`normalize <https://en.wikipedia.org/wiki/Normalization_(statistics)>`_ values.
Values will be scaled between ``0`` and ``1`` by default, if no desired bounds are provided.

Interface: `Scaleable`_

Signature: ``Collection::scale(float $lowerBound, float $upperBound, float $wantedLowerBound = 0.0, float $wantedUpperBound = 1.0, float $base = 0.0): Collection;``

.. code-block:: php

    $default = Collection::fromIterable([0, 5, 10, 15, 20])
        ->scale(0, 20); // [0, 0.25, 0.5, 0.75, 1]

    $withBounds = Collection::fromIterable([0, 5, 10, 15, 20])
        ->scale(0, 20, 0, 12); // [0, 3, 6, 9, 12]

    $withBoundsAndBase = Collection::fromIterable([0, 5, 10, 15, 20])
        ->scale(0, 20, 0, 12, \M_E); // [1, 6.90, 9.45, 10.94, 12]

scanLeft
~~~~~~~~

Takes the initial value and the first item of the list and applies the function to them, then feeds the function with
this result and the second argument and so on. It returns the list of intermediate and final results.

Interface: `ScanLeftable`_

Signature: ``Collection::scanLeft(callable $callback, $initial = null): Collection;``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $carry / $value;
    };

    Collection::fromIterable([4, 2, 4])
        ->scanLeft($callback, 64)
        ->normalize(); // [64, 16, 8, 2]

    Collection::empty()
        ->scanLeft($callback, 3); // [0 => 3]


scanLeft1
~~~~~~~~~

Takes the first two items of the list and applies the function to them, then
feeds the function with this result and the third argument and so on.
It returns the list of intermediate and final results.

.. warning:: You might need to use the ``normalize`` operation after this.

Interface: `ScanLeft1able`_

Signature: ``Collection::scanLeft1(callable $callback): Collection;``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $carry / $value;
    };

    Collection::fromIterable([64, 4, 2, 8])
        ->scanLeft1($callback); // [64, 16, 8, 1]

    Collection::fromIterable([12])
        ->scanLeft1($callback); // [12]

    Collection::empty()
        ->scanLeft1($callback); // []

scanRight
~~~~~~~~~

Takes the initial value and the last item of the list and applies the function, then it takes the penultimate item from
the end and the result, and so on. It returns the list of intermediate and final results.

Interface: `ScanRightable`_

Signature: ``Collection::scanRight(callable $callback, $initial = null): Collection;``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $value / $carry;
    };

    Collection::fromIterable([8, 12, 24, 4])
        ->scanRight($callback, 2); // [8, 1, 12, 2, 2]

    Collection::empty()
        ->scanRight($callback, 3); // [3]

scanRight1
~~~~~~~~~~

Takes the last two items of the list and applies the function, then it takes the
third item from the end and the result, and so on. It returns the list of
intermediate and final results.

.. warning:: You might need to use the ``normalize`` operation after this.

Interface: `ScanRight1able`_

Signature: ``Collection::scanRight1(callable $callback): Collection;``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $value / $carry;
    };

    Collection::fromIterable([8, 12, 24, 2])
        ->scanRight1($callback); // [8, 1, 12, 2]

    Collection::fromIterable([12])
        ->scanRight1($callback); // [12]

    Collection::empty()
        ->scanRight1($callback); // []

shuffle
~~~~~~~

Shuffle a collection, randomly changing the order of items.

Interface: `Shuffleable`_

Signature: ``Collection::shuffle(?int $seed = null): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->random(); // ['6', '4', '5']

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->random(); // ['5', '6', '5']

since
~~~~~

Skip items until the callback is met.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

Interface: `Sinceable`_

Signature: ``Collection::since(callable ...$callbacks): Collection;``

.. literalinclude:: code/operations/since.php
  :language: php

slice
~~~~~

Get a slice of a collection.

Interface: `Sliceable`_

Signature: ``Collection::slice(int $offset, ?int $length = -1): Collection;``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'z'))
        ->slice(5, 3); // [5 => 'f', 6 => 'g', 7 => 'h']

sort
~~~~

Sort a collection using a callback. If no callback is provided, it will sort using natural order.

By default, it will sort by values and using a callback. If you want to sort by keys, you can pass a parameter to change
the behavior or use twice the flip operation. See the example below.

Interface: `Sortable`_

Signature: ``Collection::sort(int $type = Sortable::BY_VALUES, ?callable $callback = null): Collection;``

.. literalinclude:: code/operations/sort.php
  :language: php

span
~~~~

Partition the collection into two subgroups where the first element is the longest
prefix (*possibly empty*) of elements that satisfy the callback(s) and the second element
is the remainder.

The raw ``Span`` operation returns a generator yielding two iterators.

The first inner iterator is the result of a ``TakeWhile`` operation.
The second (and last) inner iterator is the result of a ``DropWhile`` operation.

When the ``span`` operation is used through the ``Collection`` object, the two
resulting iterators will be converted and mapped into ``Collection`` objects.

Interface: `Spanable`_

Signature: ``Collection::span(callable ...$callbacks): Collection;``

.. literalinclude:: code/operations/span.php
  :language: php

split
~~~~~

Split a collection using one or more callbacks.

A flag must be provided in order to specify whether the value used to split the collection should be added at the end
of a chunk, at the beginning of a chunk, or completely removed.

Interface: `Splitable`_

Signature: ``Collection::split(int $type = Splitable::BEFORE, callable ...$callbacks): Collection;``

.. code-block:: php

    $splitter = static function ($value): bool => 0 === $value % 3;

    $collection = Collection::fromIterable(range(0, 10))
        ->split(Splitable::BEFORE, $splitter); // [[0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10]]

    $collection = Collection::fromIterable(range(0, 10))
        ->split(Splitable::AFTER, $splitter); [[0], [1, 2, 3], [4, 5, 6], [7, 8, 9], [10]]

    $collection = Collection::fromIterable(range(0, 10))
        ->split(Splitable::REMOVE, $splitter); [[], [1, 2], [4, 5], [7, 8], [10]]

squash
~~~~~~

Eagerly apply operations in a collection rather than lazily.

Interface: `Squashable`_

Signature: ``Collection::squash(): Collection;``

.. literalinclude:: code/operations/squash.php
  :language: php

strict
~~~~~

Enforce a single type in the collection at runtime. If the collection contains *objects*, they will either be
expected to implement the same interfaces or be of the exact same class (no inheritance logic applies).

Note that the current logic allows *arrays* of any type in the collection, as well as *null*.

.. warning:: This will trigger an ``InvalidArgumentException`` if the collection contains elements of mixed types when consumed.

.. tip:: The logic for determining the type of items comes from the `TypedIterator`_.
    In addition, an optional callback can be provided to this operation if a different logic for type enforcement is desired.

Interface: `Strictable`_

Signature: ``Collection::strict(?callable $callback = null): Collection;``

.. literalinclude:: code/operations/strict.php
    :language: php

tail
~~~~

Get the collection items except the first.

Interface: `Tailable`_

Signature: ``Collection::tail(): Collection;``

.. code-block:: php

    Collection::fromIterable(['a', 'b', 'c'])
        ->tail(); // [1 => 'b', 2 => 'c']

tails
~~~~~

Returns the list of initial segments of the collection, shortest last.
Similar to applying ``tail`` successively and collecting all results in one list.

Interface: `Tailsable`_

Signature: ``Collection::tails(): Collection;``

.. code-block:: php

    Collection::fromIterable(['a', 'b', 'c'])
        ->tails(); // [['a', 'b', 'c'], ['b', 'c'], ['c'], []]

takeWhile
~~~~~~~~~

Iterate over the collection items while the provided callback(s) are satisfied.

It stops iterating when the callback(s) are not met.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

Be careful, this operation is not the same as the ``filter`` operation.

Interface: `TakeWhileable`_

Signature: ``Collection::takeWhile(callable ...$callbacks): Collection;``

.. code-block:: php

    $isSmallerThanThree = static function (int $value): bool {
        return 3 > $value;
    };

    Collection::fromIterable([1,2,3,4,5,6,7,8,9,1,2,3])
        ->takeWhile($isSmallerThanThree); // [1,2]

transpose
~~~~~~~~~

Computes the `transpose <https://en.wikipedia.org/wiki/Transpose>`_ of a matrix.

Interface: `Transposeable`_

Signature: ``Collection::transpose(): Collection;``

.. literalinclude:: code/operations/transpose.php
  :language: php

truthy
~~~~~~

Check if the collection contains *only truthy* values. Opposite of ``falsy``.

A value is determined to be *truthy* by applying a ``bool`` cast.

Interface: `Truthyable`_

Signature: ``Collection::truthy(): bool;``

.. code-block:: php

    $result = Collection::fromIterable([2, 3, 4])
        ->truthy(); // true

    $result = Collection::fromIterable(['a', '', 'c', 'd'])
        ->truthy(); // false

unlines
~~~~~~~

Opposite of ``lines``, creates a single string from multiple lines using ``PHP_EOL`` as the glue.

Interface: `Unlinesable`_

Signature: ``Collection::unlines(): Collection;``

.. code-block:: php

    $lines = [
        'The quick brown fox jumps over the lazy dog.',
        '',
        'This is another sentence.',
    ];

    Collection::fromIterable($lines)
        ->unlines();
    // [
    //    'The quick brown fox jumps over the lazy dog.
    //
    //     This is another sentence.'
    // ]

unpack
~~~~~~

Opposite of ``pack``, transforms groupings of items representing a key and a value into actual keys and values.

Interface: `Unpackable`_

Signature: ``Collection::unpack(): Collection;``

.. code-block:: php

    $input = [['a', 'b'], ['c', 'd'], ['e', 'f']];

    $c = Collection::fromIterable($input)
        ->unpack();

    // [
    //     ['a' => 'b'],
    //     ['c' => 'd'],
    //     ['e' => 'f'],
    // ];

unpair
~~~~~~

Opposite of ``pair``, creates a flat list of values from a collection of key-value pairs.

Interface: `Unpairable`_

Signature: ``Collection::unpair(): Collection;``

.. code-block:: php

    $input = [
        'k1' => 'v1',
        'k2' => 'v2',
        'k3' => 'v3',
        'k4' => 'v4',
    ];

    $c = Collection::fromIterable($input)
        ->unpair(); // ['k1', 'v1', 'k2', 'v2', 'k3', 'v3', 'k4', 'v4']

until
~~~~~

Iterate over the collection items until the provided callback(s) are satisfied.

.. warning:: The `callbacks` parameter is variadic and will be evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have to make multiple calls to the
             same operation.

Interface: `Untilable`_

Signature: ``Collection::until(callable ...$callbacks): Collection;``

.. code-block:: php

    // The Collatz conjecture (https://en.wikipedia.org/wiki/Collatz_conjecture)
    $collatz = static fn (int $value): array => 0 === $value % 2
            ? [$value / 2]
            : [$value * 3 + 1];

    $collection = Collection::unfold($collatz, 10)
        ->unwrap()
        ->until(static fn ($number): bool => 1 === $number);

unwindow
~~~~~~~~

Opposite of ``window``, usually needed after a call to that operation.
Turns already-created windows back into a flat list.

Interface: `Unwindowable`_

Signature: ``Collection::unwindow(): Collection;``

.. code-block:: php

    // Drop all the items before finding five 9 in a row.
    $input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 9, 9, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];

    Collection::fromIterable($input)
        ->window(4)
        ->dropWhile(static fn (array $value): bool => $value !== [9, 9, 9, 9, 9])
        ->unwindow()
        ->drop(1)
        ->normalize(); // [10, 11, 12, 13, 14, 15, 16, 17, 18]

unwords
~~~~~~~

Opposite of ``words`` and similar to ``lines``,
creates a single string from multiple strings using one space as the glue.

Interface: `Unwordsable`_

Signature: ``Collection::unwords(): Collection;``

.. code-block:: php

    $words = [
        'The',
        'quick',
        'brown',
        'fox',
        'jumps',
        'over',
        'the',
        'lazy',
        'dog.'
    ];

    Collection::fromIterable($words)
        ->unwords(); // ['The quick brown fox jumps over the lazy dog.']

unwrap
~~~~~~

Opposite of ``wrap``, turn a collection of arrays into a flat list.
Equivalent to ``Collection::flatten(1)``.

Interface: `Unwrapable`_

Signature: ``Collection::unwrap(): Collection;``

.. code-block:: php

    $asociative = Collection::fromIterable([['a' => 'A'], ['b' => 'B'], ['c' => 'C']])
        ->unwrap(); // ['a' => 'A', 'b' => 'B', 'c' => 'C']

    $list = Collection::fromIterable([['a'], ['b'], ['c']])
        ->unwrap(); // ['a', 'b', 'c']

unzip
~~~~~

Opposite of ``zip``, splits zipped items in a collection.

Interface: `Unzipable`_

Signature: ``Collection::unzip(): Collection;``

.. code-block:: php

    $a = Collection::fromIterable(['a' => 'a', 'b' => 'b', 'c' => 'c'])
        ->zip(['d', 'e', 'f', 'g'], [1, 2, 3, 4, 5]);

    $b = Collection::fromIterable($a)
        ->unzip(); // [ ['a','b','c',null,null], ['d','e','f','g',null], [1,2,3,4,5] ]

when
~~~~

This operation will execute the given ``$whenTrue`` callback when the given ``$predicate`` callback
evaluates to true. Otherwise it will execute the ``$whenFalse`` callback if any.

Unlike the ``ifThenElse`` operation where the operation is applied to each element of the collection,
this operation operates on the collection directly.

Interface: `Whenable`_

Signature: ``Collection::when(callable $predicate, callable $whenTrue, ?callable $whenFalse = null): Collection;``

.. code-block:: php

    Collection::fromIterable([1, 2])
        ->when(
            static fn() => true,
            static fn(Iterator $collection): Collection => Collection::fromIterable($collection)->append(3)
        ); // [1, 2, 3]

window
~~~~~~

Loop the collection yielding windows of data by adding a given number of items to the current item.
Initially the windows yielded will be smaller, until size ``1 + $size`` is reached.

.. tip:: To remove the window size constraint and have a dynamic window size, set the ``$size`` to ``-1``.

.. note:: When ``$size`` is equal to ``0``, the window will only contain the current element, wrapped in an array.

Interface: `Windowable`_

Signature: ``Collection::window(int $size): Collection;``

.. literalinclude:: code/operations/window.php
  :language: php

words
~~~~~

Get a list of words from a string, splitting based on the character set: ``\t, \n, ' '``.

Interface: `Wordsable`_

Signature: ``Collection::words(): Collection;``

.. code-block:: php

    $string = <<<'EOF'
    The quick brown fox jumps over the lazy dog.

    This is another sentence.
    EOF;

    Collection::fromString($string)
        ->words();
    // ['The', 'quick', 'brown', 'fox', 'jumps', 'over', 'the', 'lazy', 'dog.', 'This', 'is', 'another', 'sentence.']

wrap
~~~~

Wrap every element into an array.

Interface: `Wrapable`_

Signature: ``Collection::wrap(): Collection;``

.. code-block:: php

     $associative = Collection::fromIterable(['a' => 'A', 'b' => 'B', 'c' => 'C'])
        ->wrap(); // [['a' => 'A'], ['b' => 'B'], ['c' => 'C']]

     $list = Collection::fromIterable(range('a', 'c'))
        ->wrap(); // [[0 => 'a'], [1 => 'b'], [2 => 'c']]

zip
~~~

Zip a collection together with one or more iterables.

Interface: `Zipable`_

Signature: ``Collection::zip(iterable ...$iterables): Collection;``

.. code-block:: php

    $even = Collection::range(0, INF, 2);
    $odd = Collection::range(1, INF, 2);

    $positiveIntegers = Collection::fromIterable($even)
        ->zip($odd)
        ->limit(100)
        ->unwrap(); // [0, 1, 2, 3 ... 196, 197, 198, 199]

.. _Allable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Allable.php
.. _Appendable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Appendable.php
.. _Applyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Applyable.php
.. _Associateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Associateable.php
.. _AsyncMapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/AsyncMapable.php
.. _AsyncMapNable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/AsyncMapNable.php
.. _Averagesable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Averagesable.php
.. _Cacheable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Cacheable.php
.. _Chunkable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Chunkable.php
.. _Collapseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Collapseable.php
.. _Columnable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Columnable.php
.. _Combinateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Combinateable.php
.. _Combineable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Combineable.php
.. _Compactable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Compactable.php
.. _Coalesceable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Coalesceable.php
.. _Containsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Containsable.php
.. _Currentable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Currentable.php
.. _Cycleable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Cycleable.php
.. _Diffable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Diffable.php
.. _Diffkeysable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Diffkeysable.php
.. _Distinctable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Distinctable.php
.. _Dropable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Dropable.php
.. _DropWhileable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/DropWhileable.php
.. _Dumpable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Dumpable.php
.. _Duplicateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Duplicateable.php
.. _Equalsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Equalsable.php
.. _Everyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Everyable.php
.. _Explodeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Explodeable.php
.. _Falsyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Falsyable.php
.. _Filterable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Filterable.php
.. _Findable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Findable.php
.. _Firstable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Firstable.php
.. _FlatMapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/FlatMapable.php
.. _Flattenable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Flattenable.php
.. _Flipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Flipable.php
.. _FoldLeftable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/FoldLeftable.php
.. _FoldLeft1able: https://github.com/loophp/collection/blob/master/src/Contract/Operation/FoldLeft1able.php
.. _FoldRightable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/FoldRightable.php
.. _FoldRight1able: https://github.com/loophp/collection/blob/master/src/Contract/Operation/FoldRight1able.php
.. _Forgetable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Forgetable.php
.. _Frequencyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Frequencyable.php
.. _Getable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Getable.php
.. _Groupable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Groupable.php
.. _GroupByable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/GroupByable.php
.. _Hasable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Hasable.php
.. _Headable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Headable.php
.. _IfThenElseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/IfThenElseable.php
.. _Implodeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Implodeable.php
.. _Initable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Initable.php
.. _Initsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Initsable.php
.. _Intersectable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Intersectable.php
.. _Intersectkeysable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Intersectkeysable.php
.. _Intersperseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Intersperseable.php
.. _IsEmptyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/IsEmptyable.php
.. _Keyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Keyable.php
.. _Keysable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Keysable.php
.. _Lastable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Lastable.php
.. _Limitable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Limitable.php
.. _Linesable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Linesable.php
.. _Mapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Mapable.php
.. _MapNable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/MapNable.php
.. _Matchable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Matchable.php
.. _Matchingable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Matchingable.php
.. _Mergeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Mergeable.php
.. _Normalizeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Normalizeable.php
.. _Nthable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Nthable.php
.. _Nullsyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Nullsyable.php
.. _Packable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Packable.php
.. _Padable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Padable.php
.. _Pairable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Pairable.php
.. _Partitionable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Partitionable.php
.. _Permutateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Permutateable.php
.. _Pipeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Pipeable.php
.. _Pluckable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Pluckable.php
.. _Prependable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Prependable.php
.. _Productable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Productable.php
.. _Randomable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Randomable.php
.. _Reduceable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reduceable.php
.. _Reductionable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reductionable.php
.. _Rejectable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Rejectable.php
.. _Reverseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reverseable.php
.. _RSampleable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/RSampleable.php
.. _Sameable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sameable.php
.. _Scaleable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Scaleable.php
.. _ScanLeftable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/ScanLeftable.php
.. _ScanLeft1able: https://github.com/loophp/collection/blob/master/src/Contract/Operation/ScanLeft1able.php
.. _ScanRightable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/ScanRightable.php
.. _ScanRight1able: https://github.com/loophp/collection/blob/master/src/Contract/Operation/ScanRight1able.php
.. _Shuffleable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Shuffleable.php
.. _Sinceable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sinceable.php
.. _Sliceable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sliceable.php
.. _Sortable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sortable.php
.. _Spanable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Spanable.php
.. _Splitable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Splitable.php
.. _Strictable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Strictable.php
.. _Squashable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Squashable.php
.. _Tailable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Tailable.php
.. _Tailsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Tailsable.php
.. _TakeWhileable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/TakeWhileable.php
.. _Transposeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Transposeable.php
.. _Truthyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Truthyable.php
.. _Unlinesable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unlinesable.php
.. _Unpackable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unpackagle.php
.. _Unpairable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unpairable.php
.. _Untilable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Untilable.php
.. _Unwindowable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unwindowable.php
.. _Unwordsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unwordsable.php
.. _Unwrapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unwrapable.php
.. _Unzipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Unzipable.php
.. _Whenable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Whenable.php
.. _Windowable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Windowable.php
.. _Wordsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Wordsable.php
.. _Wrapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Wrapable.php
.. _Zipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Zipable.php

.. _array_flip(): https://php.net/array_flip
.. _assertObjectEquals: https://phpunit.readthedocs.io/en/9.5/assertions.html#assertobjectequals
.. _Countable: https://www.php.net/manual/en/class.countable.php
.. _Criteria: https://www.doctrine-project.org/projects/doctrine-collections/en/1.6/index.html#matching
.. _Doctrine Collections: https://github.com/doctrine/collections
.. _Generator: https://www.php.net/manual/en/language.generators.overview.php
.. _Iterator: https://www.php.net/manual/en/class.iterator.php
.. _JsonSerializable: https://www.php.net/manual/en/class.jsonserializable.php
.. _symfony/var-dumper: https://packagist.org/packages/symfony/var-dumper
.. _Traversable: https://www.php.net/manual/en/class.traversable.php
.. _TypedIterator: https://github.com/loophp/collection/blob/master/src/Iterator/TypedIterator.php
.. _var_dump(): https://www.php.net/var_dump
