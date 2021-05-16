.. _api:

API
===

Static constructors
-------------------

empty
~~~~~

Create an empty Collection.

.. code-block:: php

    $collection = Collection::empty();

fromCallable
~~~~~~~~~~~~

Create a collection from a callable.

.. code-block:: php

    $callback = static function () {
        yield 'a';
        yield 'b';
        yield 'c';
    };

    $collection = Collection::fromCallable($callback);

fromFile
~~~~~~~~~~~~

Create a collection from a file.

.. code-block:: php

    Collection::fromFile('http://loripsum.net/api');

fromIterable
~~~~~~~~~~~~

Create a collection from an iterable.

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c']);

fromResource
~~~~~~~~~~~~

Create a collection from a resource.

.. code-block:: php

    $stream = fopen('data://text/plain,' . $string, 'rb');

    $collection = Collection::fromResource($stream);

fromString
~~~~~~~~~~

Create a collection from a string.

.. code-block:: php

    $data = file_get_contents('http://loripsum.net/api');

    $collection = Collection::fromString($data);

range
~~~~~

Build a collection from a range of values.

Signature: ``Collection::range(int $start = 0, $end = INF, $step = 1);``

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    $even = Collection::range(0, 20, 2); // [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20]

Another example

.. code-block:: php

    $even = Collection::unfold(static function ($carry) {return $carry + 2;}, -2);
    $odd = Collection::unfold(static function ($carry) {return $carry + 2;}, -1);
    // Is the same as
    $even = Collection::range(0, \INF, 2);
    $odd = Collection::range(1, \INF, 2);

times
~~~~~

Create a collection by invoking a callback a given amount of times.

If no callback is provided, then it will create a simple list of incremented integers.

Signature: ``Collection::times($number = INF, ?callable $callback = null);``

.. code-block:: php

    $collection = Collection::times(10);

unfold
~~~~~~

Create a collection by yielding from a callback with a initial value.

.. warning:: The callback return values are reused as callback arguments at the next callback call.

Signature: ``Collection::unfold(callable $callback, ...$parameters);``

.. code-block:: php

    // A list of Naturals from 1 to Infinity.
    Collection::unfold(fn($n) => $n + 1, 1)
        ->normalize();

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    Collection::unfold($fibonacci)
        ->limit(10); // [[0, 1], [1, 1], [1, 2], [2, 3], [3, 5], [5, 8], [8, 13], [13, 21], [21, 34], [34, 55]]

Another example

.. code-block:: php

    $even = Collection::unfold(static function (int $carry): int {return $carry + 2;}, -2);
    $odd = Collection::unfold(static function (int $carry): int {return $carry + 2;}, -1);
    // Is the same as
    $even = Collection::range(0, \INF, 2);
    $odd = Collection::range(1, \INF, 2);

Methods (operations)
--------------------

.. note::
	Operations always returns a new collection object, with the exception of ``all``, ``count``, ``current``, ``key``.


all
~~~

Convert the collection into an array.

This is a lossy operation because PHP array keys cannot be duplicated and must either be int or string.

Interface: `Allable`_

Signature: ``Collection::all();``

.. code-block:: php

        $generator = static function (): Generator {
            yield 0 => 'a';
            yield 1 => 'b';
            yield 0 => 'c';
            yield 2 => 'd';
        };

        Collection::fromIterable($generator())
            ->all(); // [0 => 'c', 1 => 'b', 2 => 'd']

append
~~~~~~

Add one or more items to a collection.

.. warning:: If appended values overwrite existing values, you might find that this operation doesn't work correctly
             when the collection is converted into an array.
             It's always better to never convert the collection to an array and use it in a loop.
             However, if for some reason, you absolutely need to convert it into an array, then use the
             ``Collection::normalize()`` operation.

Interface: `Appendable`_

Signature: ``Collection::append(...$items);``

.. code-block:: php

    Collection::fromIterable([1 => '1', 2 => '2', 3 => '3'])
        ->append('4'); // [1 => '1', 2 => '2', 3 => '3', 0 => '4']

    Collection::fromIterable(['1', '2', '3'])
        ->append('4')
        ->append('5', '6'); // [0 => 5, 1 => 6, 2 => 3]

    Collection::fromIterable(['1', '2', '3'])
        ->append('4')
        ->append('5', '6')
        ->normalize(); // ['1', '2', '3', '4', '5', '6']

apply
~~~~~

Execute callback(s) on each element of the collection.

Iterates on the collection items regardless of the return value of the callback.

If the callback does not return ``true`` then it stops applying callbacks on subsequent items.

Interface: `Applyable`_

Signature: ``Collection::apply(...$callbacks);``

.. code-block:: php

    $callback = static function ($value, $key): bool
        {
            var_dump('Value is: ' . $value . ', key is: ' . $key);

            return true;
        };

    $collection = Collection::fromIterable(['1', '2', '3']);

    $collection
        ->apply($callback);

associate
~~~~~~~~~

Transform keys and values of the collection independently and combine them.

Interface: `Associateable`_

Signature: ``Collection::associate(?callable $callbackForKeys = null, ?callable $callbackForValues = null);``

.. code-block:: php

    $input = range(1, 10);

    Collection::fromIterable($input)
        ->associate(
            static function ($key, $value) {
                return $key * 2;
            },
            static function ($key, $value) {
                return $value * 2;
            }
        );

    // [
    //   0 => 2,
    //   2 => 4,
    //   4 => 6,
    //   6 => 8,
    //   8 => 10,
    //   10 => 12,
    //   12 => 14,
    //   14 => 16,
    //   16 => 18,
    //   18 => 20,
    // ]

asyncMap
~~~~~~~~

Apply one callback to every item of a collection and use the return value.

.. warning:: Asynchronously apply callbacks to a collection. This operation is non-deterministic, we cannot ensure the elements order at the end.

.. warning:: Keys are preserved, use the "normalize" operation if you want to re-index the keys.

Interface: `AsyncMapable`_

Signature: ``Collection::asyncMap(callable ...$callbacks);``

.. code-block:: php

    $mapper1 = static function(int $value): int {
        sleep($value);

        return $value;
    };

    $mapper2 = static function(int $value): int {
        return $value * 2;
    };

    $collection = Collection::fromIterable(['c' => 3, 'b' => 2, 'a' => 1])
        ->asyncMap($mapper1, $mapper2); // ['a' => 2, 'b' => 4, 'c' => 6]

cache
~~~~~

Useful when using a resource as input and you need to run through the collection multiple times.

Interface: `Cacheable`_

Signature: ``Collection::cache(CacheItemPoolInterface $cache = null);``

.. code-block:: php

    $fopen = fopen(__DIR__ . '/vendor/autoload.php', 'r');

    $collection = Collection::fromResource($fopen)
        ->cache();

chunk
~~~~~

Chunk a collection of item into chunks of items of a given size.

Interface: `Chunkable`_

Signature: ``Collection::chunk(int $size);``

.. code-block:: php

    $collection = Collection::fromIterable(range(0, 10));

    $collection->chunk(2);

coalesce
~~~~~~~~

Return the first *non-nullsy* value in a collection.

*Nullsy* values are:

* The null value: null
* Empty array: []
* The integer zero: 0
* The boolean: false
* The empty string: ''

Interface: `Coalesceable`_

Signature: ``Collection::coalesce();``

.. literalinclude:: code/operations/coalesce.php
  :language: php

collapse
~~~~~~~~

Collapse a collection of items into a simple flat collection.

Interface: `Collapseable`_

Signature: ``Collection::collapse();``

.. code-block:: php

    $collection = Collection::fromIterable([[1,2], [3, 4]]);

    $collection->collapse(); // [1, 2, 3, 4]

column
~~~~~~

Return the values from a single column in the input iterables.

Interface: `Columnable`_

Signature: ``Collection::column($index);``

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
        ->column('first_name');

combinate
~~~~~~~~~

Get all the combinations of a given length of a collection of items.

Interface: `Combinateable`_

Signature: ``Collection::combinate(?int $length);``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c'])
        ->combinate(2); // [['a', 'b'], ['b', 'c'], ['a', 'c']]

combine
~~~~~~~

Combine a collection of items with some other keys.

Interface: `Combineable`_

Signature: ``Collection::combine(...$keys);``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd'])
        ->combine('w', 'x', 'y', 'z'); // ['w' => 'a', 'x' => 'b', 'y' => 'c', 'z' => 'd']

compact
~~~~~~~

Remove given values from the collection, if no values are provided, it removes only the null value.

Interface: `Compactable`_

Signature: ``Collection::compact(...$values);``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 1 => 'b', null, false, 0, 'c'])
        ->compact(); // ['a', 1 => 'b', 3 => false, 4 => 0, 5 => 'c']

    $collection = Collection::fromIterable(['a', 1 => 'b', null, false, 0, 'c'])
        ->compact(null, 0); // ['a', 1 => 'b', 3 => false, 5 => 'c']

contains
~~~~~~~~

Check if the collection contains one or more value.

Interface: `Containsable`_

Signature: ``Collection::contains(...$value);``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'c'))
        ->contains('d'); // [false]

    if ($collection->contains('d')->current()) {
        // do something
    }

current
~~~~~~~

Get the value of an item in the collection given a numeric index, default index is 0.

Interface: `Currentable`_

Signature: ``Collection::current(int $index = 0);``

.. code-block:: php

    Collection::fromIterable(['a', 'b', 'c', 'd'])->current(); // Return 'a'
    Collection::fromIterable(['a', 'b', 'c', 'd'])->current(0); // Return 'a'
    Collection::fromIterable(['a', 'b', 'c', 'd'])->current(1); // Return 'b'
    Collection::fromIterable(['a', 'b', 'c', 'd'])->current(10); // Return null

cycle
~~~~~

Cycle indefinitely around a collection of items.

Interface: `Cycleable`_

Signature: ``Collection::cycle();``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd'])
        ->cycle();

diff
~~~~

It compares the collection against another collection or a plain array based on its values.
This method will return the values in the original collection that are not present in the given collection.

Interface: `Diffable`_

Signature: ``Collection::diff(...$values);``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd', 'e'])
        ->diff('a', 'b', 'c', 'x'); // [3 => 'd', 4 => 'e']

diffKeys
~~~~~~~~

It compares the collection against another collection or a plain object based on its keys.
This method will return the key / value pairs in the original collection that are not present in the given collection.

Interface: `Diffkeysable`_

Signature: ``Collection::diffKeys(...$values);``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'd', 'e'])
        ->diffKeys(1, 2); // [0 => 'a', 3 => 'd', 4 => 'e']

distinct
~~~~~~~~

Remove duplicated values from a collection, preserving keys.

Interface: `Distinctable`_

Signature: ``Collection::distinct();``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'a', 'c'])
        ->distinct(); // [0 => 'a', 1 => 'b', 3 => 'c']

drop
~~~~

Drop the n first items of the collection.

Interface: `Dropable`_

Signature: ``Collection::drop(int ...$counts);``

.. code-block:: php

    Collection::fromIterable(range(10, 20))
        ->drop(2); // [12,13,14,15,16,17,18,19,20]

dropWhile
~~~~~~~~~

Iterate over the collection items and takes from it its elements from the moment when the condition fails for the
first time till the end of the list.

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Interface: `DropWhileable`_

Signature: ``Collection::dropWhile(callable ...$callbacks);``

.. code-block:: php

    $isSmallerThanThree = static function (int $value): bool {
        return 3 > $value;
    };

    Collection::fromIterable([1,2,3,4,5,6,7,8,9,1,2,3])
        ->dropWhile($isSmallerThanThree); // [3,4,5,6,7,8,9,1,2,3]

dump
~~~~

Dump one or multiple items. It uses `symfony/var-dumper`_ if it is available,
`var_dump()`_ otherwise. A custom ``callback`` might be also used.

Interface: `Dumpable`_

Signature: ``Collection::dump(string $name = '', int $size = 1, ?Closure $closure = null);``

.. code-block:: php

    Collection::fromIterable(range('a', 'e'))
        ->dump('Debug', 2); // Will debug the 2 first values.

duplicate
~~~~~~~~~

Find duplicated values from the collection.

Interface: `Duplicateable`_

Signature: ``Collection::duplicate();``

.. code-block:: php

    // It might return duplicated values !
    Collection::fromIterable(['a', 'b', 'c', 'a', 'c', 'a'])
            ->duplicate(); // [3 => 'a', 4 => 'c', 5 => 'a']

    // Use ::distinct() and ::normalize() to get what you want.
    Collection::fromIterable(['a', 'b', 'c', 'a', 'c', 'a'])
            ->duplicate()
            ->distinct()
            ->normalize() // [0 => 'a', 1 => 'c']

every
~~~~~

This operation tests whether all elements in the collection pass the test implemented by the provided callback(s).

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Interface: `Everyable`_

Signature: ``Collection::every(callable ...$callbacks);``

.. code-block:: php

    $callback = static function ($value): bool {
        return $value < 20;
    };

    Collection::fromIterable(range(0, 10))
        ->every($callback)
        ->current(); // true

    Collection::fromIterable(range(0, 10))
        ->append(21)
        ->every($callback)
        ->current(); // false

    Collection::fromIterable([])
        ->every($callback)
        ->current(); // true

explode
~~~~~~~

Explode a collection into subsets based on a given value.

This operation use the Split operation with the flag ``Splitable::REMOVE`` and thus, values used to explode the
collection are removed from the chunks.

Interface: `Explodeable`_

Signature: ``Collection::explode(...$items);``

.. code-block:: php

    $string = 'I am a text.';

    $collection = Collection::fromIterable($string)
        ->explode(' '); // [['I', 'a', 'm', 'a', 't', 'e', 'x', 't', '.']]

falsy
~~~~~

Check if the collection contains falsy values.

Interface: `Falsyable`_

Signature: ``Collection::falsy();``

filter
~~~~~~

Filter collection items based on one or more callbacks.

Interface: `Filterable`_

Signature: ``Collection::filter(callable ...$callbacks);``

.. code-block:: php

    $callback = static function($value): bool {
        return 0 === $value % 3;
    };

    $collection = Collection::fromIterable(range(1, 100))
        ->filter($callback);

first
~~~~~

Get the first items from the collection.

Interface: `Firstable`_

Signature: ``Collection::first();``

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
            ->first(); // ['a' => 'a']

flatten
~~~~~~~

Flatten a collection of items into a simple flat collection.

Interface: `Flattenable`_

Signature: ``Collection::flatten(int $depth = PHP_INT_MAX);``

.. code-block:: php

    $collection = Collection::fromIterable([0, [1, 2], [3, [4, [5, 6]]]])
        ->flatten();

flip
~~~~

Flip keys and items in a collection.

Interface: `Flipable`_

Signature: ``Collection::flip(int $depth = PHP_INT_MAX);``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'a'])
        ->flip();

.. tip:: array_flip() and Collection::flip() can behave different, check the following examples.

When using regular arrays, `array_flip()`_ can be used to remove duplicates (dedup-licate an array).

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

Takes the initial value and the first item of the list and applies the function to them, then feeds the function with
this result and the second argument and so on. See ``scanLeft`` for intermediate results.

Interface: `FoldLeftable`_

Signature: ``Collection::foldLeft(callable $callback, $initial = null);``

foldLeft1
~~~~~~~~~

Takes the first 2 items of the list and applies the function to them, then feeds the function with this result and the
third argument and so on. See ``scanLeft1`` for intermediate results.

Interface: `FoldLeft1able`_

Signature: ``Collection::foldLeft1(callable $callback);``

foldRight
~~~~~~~~~

Takes the initial value and the last item of the list and applies the function, then it takes the penultimate item from
the end and the result, and so on. See ``scanRight`` for intermediate results.

Interface: `FoldRightable`_

Signature: ``Collection::foldRight(callable $callback, $initial = null);``

foldRight1
~~~~~~~~~~

Takes the last two items of the list and applies the function, then it takes the third item from the end and the result,
and so on. See ``scanRight1`` for intermediate results.

Interface: `FoldRight1able`_

Signature: ``Collection::foldRight1(callable $callback);``

forget
~~~~~~

Remove items having specific keys.

Interface: `Forgetable`_

Signature: ``Collection::forget(...$keys);``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'z'))
        ->forget(5, 6, 10, 15);

frequency
~~~~~~~~~

Calculate the frequency of the values, frequencies are stored in keys.

Values can be anything (object, scalar, ... ).

Interface: `Frequencyable`_

Signature: ``Collection::frequency();``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c', 'b', 'c', 'c')
        ->frequency()
        ->all(); // [1 => 'a', 2 => 'b', 3 => 'c'];

get
~~~

Get a specific element of the collection from a key, if the key doesn't exists, returns the default value.

Interface: `Getable`_

Signature: ``Collection::get($key, $default = null);``

group
~~~~~

Takes a list and returns a list of lists such that the concatenation of the result is equal to the argument.
Moreover, each sublist in the result contains only equal elements.

Interface: `Groupable`_

Signature: ``Collection::group();``

.. code-block:: php

    Collection::fromString('Mississippi')
        ->group(); // [ [0 => 'M'], [1 => 'i'], [2 => 's', 3 => 's'], [4 => 'i'], [5 => 's', 6 => 's'], [7 => 'i'], [8 => 'p', 9 => 'p'], [10 => 'i'] ]

groupBy
~~~~~~~

Group items, the key used to group items can be customized in a callback.
By default it's the key is the item's key.

Interface: `GroupByable`_

Signature: ``Collection::groupBy(?callable $callback = null);``

.. code-block:: php

    $callback = static function () {
            yield 1 => 'a';

            yield 1 => 'b';

            yield 1 => 'c';

            yield 2 => 'd';

            yield 2 => 'e';

            yield 3 => 'f';
    };

    $collection = Collection::fromIterable($callback)
        ->groupBy();

has
~~~

Check if the collection has values.

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Interface: `Hasable`_

Signature: ``Collection::has(callable ...$callbacks);``

.. code-block:: php

    Collection::fromIterable(range('A', 'C'))
        ->has(
            static fn ($value, $key, Iterator $iterator): string => 'A'
        ); // [true]

    Collection::fromIterable(range('A', 'C'))
        ->has(
            static fn ($value, $key, Iterator $iterator): string => 'D'
        ); // [false]

    Collection::fromIterable(range('A', 'C'))
        ->has(
            static fn ($value, $key, Iterator $iterator): string => 'A',
            static fn ($value, $key, Iterator $iterator): string => 'Z'
        ); // [true]

head
~~~~

Interface: `Headable`_

Signature: ``Collection::head();``

.. code-block:: php

    $generator = static function (): \Generator {
            yield 1 => 'a';
            yield 1 => 'b';
            yield 1 => 'c';
            yield 2 => 'd';
            yield 2 => 'e';
            yield 3 => 'f';
    };

    Collection::fromIterable($generator())
        ->head(); // [1 => 'a']

ifThenElse
~~~~~~~~~~

Execute a callback when a condition is met.

Interface: `IfThenElseable`_

Signature: ``Collection::ifThenElse(callable $condition, callable $then, ?callable $else = null);``

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

Convert all the elements of the collection to a single string.

The glue character can be provided, default is the empty character.

Interface: `Implodeable`_

Signature: ``Collection::implode(string $glue = '');``

init
~~~~

Returns the collection without its last item.

Interface: `Initable`_

Signature: ``Collection::init();``

.. code-block:: php

    Collection::fromIterable(range('a', 'e'))
        ->init(); // ['a', 'b', 'c', 'd']

inits
~~~~~

Returns all initial segments of the collection, shortest first.

Interface: `Initsable`_

Signature: ``Collection::inits();``

.. code-block:: php

    Collection::fromIterable(range('a', 'c'))
        ->inits(); // [[], ['a'], ['a', 'b'], ['a', 'b', 'c']]

intersect
~~~~~~~~~

Removes any values from the original collection that are not present in the given collection.

Interface: `Intersectable`_

Signature: ``Collection::intersect(...$values);``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'e'))
        ->intersect('a', 'b', 'c'); // ['a', 'b', 'c']

intersectKeys
~~~~~~~~~~~~~

Removes any keys from the original collection that are not present in the given collection.

Interface: `Intersectkeysable`_

Signature: ``Collection::intersectKeys(...$values);``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'e'))
        ->intersectKeys(0, 2, 4); // ['a', 'c', 'e']

intersperse
~~~~~~~~~~~

Insert a given value at every n element of a collection and indices are not preserved.

Interface: `Intersperseable`_

Signature: ``Collection::intersperse($element, int $every = 1, int $startAt = 0);``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'z'))
        ->intersperse('foo', 3);

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

Signature: ``Collection::keys();``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'z'))
        ->keys();

last
~~~~

Extract the last element of a collection, which must be finite and non-empty.

Interface: `Lastable`_

Signature: ``Collection::last();``

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
            ->last(); // ['c' => 'f']

limit
~~~~~

Limit the amount of values in the collection.

Interface: `Limitable`_

Signature: ``Collection::limit(int $limit);``

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    $collection = Collection::unfold($fibonacci)
        ->limit(10);

lines
~~~~~

Split a string into lines.

Interface: `Linesable`_

Signature: ``Collection::lines();``

.. code-block:: php

    $string = <<<'EOF'
    The quick brow fox jumps over the lazy dog.

    This is another sentence.
    EOF;

    Collection::fromString($string)
        ->lines();

map
~~~

Apply one or more supplied callbacks to every item of a collection and use the return value.

.. warning:: Keys are preserved, use the "normalize" operation if you want to re-index the keys.

Interface: `Mapable`_

Signature: ``Collection::map(callable ...$callbacks);``

.. code-block:: php

    $mapper = static function($value, $key) {
        return $value * 2;
    };

    $collection = Collection::fromIterable(range(1, 100))
        ->map($mapper);

match
~~~~~

Check if the collection match a ``user callback``.

User must provide a callback that will get the ``key``, the ``current value`` and the ``iterator`` as parameters.

When no matcher callback is provided, the user callback must return ``true`` (the
default value of the ``matcher callback``) in order to stop.

The returned value of the operation is ``true`` when the callback match at least one element
of the collection. ``false`` otherwise.

If you want to match the ``user callback`` against another value (other than ``true``), you must
provide your own ``matcher callback`` as a second argument, it must returns a ``boolean``.

Interface: `Matchable`_

Signature: ``Collection::match(callable $callback, ?callable $matcher = null);``

.. literalinclude:: code/operations/match.php
  :language: php

merge
~~~~~

Merge one or more collection of items onto a collection.

Interface: `Mergeable`_

Signature: ``Collection::merge(...$sources);``

.. code-block:: php

    $collection = Collection::fromIterable(range(1, 10))
        ->merge(['a', 'b', 'c'])

normalize
~~~~~~~~~

Replace, reorder and use numeric keys on a collection.

Interface: `Normalizeable`_

Signature: ``Collection::normalize();``

.. code-block:: php

    $collection = Collection::fromIterable(['a' => 'a', 'b' => 'b', 'c' => 'c'])
        ->normalize();

nth
~~~

Get every n-th element of a collection.

Interface: `Nthable`_

Signature: ``Collection::nth(int $step, int $offset = 0);``

.. code-block:: php

    $collection = Collection::fromIterable(range(10, 100))
        ->nth(3);

nullsy
~~~~~~

Check if the collection contains *nullsy* values.

*Nullsy* values are:

* The null value: ``null``
* Empty array: ``[]``
* The integer zero: ``0``
* The boolean: ``false``
* The empty string: ``''``

Interface: `Nullsyable`_

Signature: ``Collection::nullsy();``

only
~~~~

Get items having corresponding given keys.

Interface: `Onlyable`_

Signature: ``Collection::only(...$keys);``

.. code-block:: php

    $collection = Collection::fromIterable(range(10, 100))
        ->only(3, 10, 'a', 9);

pack
~~~~

Wrap each items into an array containing 2 items: the key and the value.

Interface: `Packable`_

Signature: ``Collection::pack();``

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

Signature: ``Collection::pad(int $size, $value);``

.. code-block:: php

    $collection = Collection::fromIterable(range(1, 5))
        ->pad(10, 'foo');

pair
~~~~

Make an associative collection from pairs of values.

Interface: `Pairable`_

Signature: ``Collection::pair();``

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
        ->pair()
        ->group()
        ->all();

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

With one or multiple callable, partition the items into 2 subgroups of items.

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Interface: `Partitionable`_

Signature: ``Collection::partition(callable ...$callbacks);``

.. literalinclude:: code/operations/partition.php
  :language: php

permutate
~~~~~~~~~

Find all the permutations of a collection.

Interface: `Permutateable`_

Signature: ``Collection::permutate(int $size, $value);``

.. code-block:: php

    $collection = Collection::fromIterable(['hello', 'how', 'are', 'you'])
        ->permutate();

pluck
~~~~~

Retrieves all of the values of a collection for a given key.

Interface: `Pluckable`_

Signature: ``Collection::pluck($pluck, $default = null);``

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    $collection = Collection::unfold($fibonacci)
        ->limit(10)
        ->pluck(0);

prepend
~~~~~~~

Push an item onto the beginning of the collection.

.. warning:: If prepended values overwrite existing values, you might find that this operation doesn't work correctly
             when the collection is converted into an array.
             It's always better to never convert the collection to an array and use it in a loop.
             However, if for some reason, you absolutely need to convert it into an array, then use the
             ``Collection::normalize()`` operation.

Interface: `Prependable`_

Signature: ``Collection::prepend(...$items);``

.. code-block:: php

    Collection::fromIterable([1 => '1', 2 => '2', 3 => '3'])
        ->prepend('4'); // [0 => 4, 1 => '1', 2 => '2', 3 => '3']

    Collection::fromIterable(['1', '2', '3'])
        ->prepend('4')
        ->prepend('5', '6'); // [0 => 1, 1 => 2, 2 => 3]

    Collection::fromIterable(['1', '2', '3'])
        ->prepend('4')
        ->prepend('5', '6')
        ->normalize(); // ['5', '6', '4', '1', '2', '3']

product
~~~~~~~

Get the the cartesian product of items of a collection.

Interface: `Productable`_

Signature: ``Collection::product(iterable ...$iterables);``

.. code-block:: php

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->product(['1', '2', '3'], ['a', 'b'], ['foo', 'bar']);

random
~~~~~~

It returns a random item from the collection.

An optional integer can be passed to random to specify how many items you would like to randomly retrieve.
An optional seed can be passed as well.

Interface: `Randomable`_

Signature: ``Collection::random(int $size = 1, ?int $seed = null);``

.. code-block:: php

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->random(); // ['6']

reduction
~~~~~~~~~

Reduce a collection of items through a given callback.

Interface: `Reductionable`_

Signature: ``Collection::reduction(callable $callback, $initial = null);``

.. code-block:: php

    $multiplication = static function ($value1, $value2) {
        return $value1 * $value2;
    };

    $addition = static function ($value1, $value2) {
        return $value1 + $value2;
    };

    $fact = static function (int $number) use ($multiplication) {
        return Collection::range(1, $number + 1)
            ->reduce(
                $multiplication,
                1
            );
    };

    $e = static function (int $value) use ($fact): float {
        return $value / $fact($value);
    };

    $number_e_approximation = Collection::times()
        ->map($e)
        ->limit(10)
        ->reduction($addition);

reverse
~~~~~~~

Reverse order items of a collection.

Interface: `Reverseable`_

Signature: ``Collection::reverse();``

.. code-block:: php

    $collection = Collection::fromIterable(['a', 'b', 'c'])
        ->reverse();

rsample
~~~~~~~

Work in progress... sorry.

scale
~~~~~

Scale/normalize values.

Interface: `Scaleable`_

Signature: ``Collection::scale(float $lowerBound, float $upperBound, ?float $wantedLowerBound = null, ?float $wantedUpperBound = null, ?float $base = null);``

.. code-block:: php

    $collection = Collection::range(0, 10, 2)
        ->scale(0, 10);

    $collection = Collection::range(0, 10, 2)
        ->scale(0, 10, 5, 15, 3);

scanLeft
~~~~~~~~

Takes the initial value and the first item of the list and applies the function to them, then feeds the function with
this result and the second argument and so on. It returns the list of intermediate and final results.

Interface: `ScanLeftable`_

Signature: ``Collection::scanLeft(callable $callback, $initial = null);``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $carry / $value;
    };

    Collection::fromIterable([4, 2, 4])
        ->scanLeft($callback, 64)
        ->normalize(); // [64 ,16 ,8 ,2]

    Collection::empty()
        ->scanLeft($callback, 3); // [0 => 3]


scanLeft1
~~~~~~~~~

Takes the first 2 items of the list and applies the function to them, then feeds the function with this result and the
third argument and so on. It returns the list of intermediate and final results.

.. warning:: You might need to use the ``normalize`` operation after this.

Interface: `ScanLeft1able`_

Signature: ``Collection::scanLeft1(callable $callback);``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $carry / $value;
    };

    Collection::fromIterable([64, 4, 2, 8])
        ->scanLeft1($callback); // [64 ,16 ,8 ,1]

    Collection::fromIterable([12])
        ->scanLeft1($callback); // [12]

scanRight
~~~~~~~~~

Takes the initial value and the last item of the list and applies the function, then it takes the penultimate item from
the end and the result, and so on. It returns the list of intermediate and final results.

Interface: `ScanRightable`_

Signature: ``Collection::scanRight(callable $callback, $initial = null);``

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

Takes the last two items of the list and applies the function, then it takes the third item from the end and the result,
and so on. It returns the list of intermediate and final results.

.. warning:: You might need to use the ``normalize`` operation after this.

Interface: `ScanRight1able`_

Signature: ``Collection::scanRight1(callable $callback);``

.. code-block:: php

    $callback = static function ($carry, $value) {
        return $value / $carry;
    };

    Collection::fromIterable([8, 12, 24, 2])
        ->scanRight1($callback); // [8, 1, 12, 2]

    Collection::fromIterable([12])
        ->scanRight1($callback); // [12]

shuffle
~~~~~~~

Shuffle a collection.

Interface: `Shuffleable`_

Signature: ``Collection::shuffle(?int $seed = null);``

.. code-block:: php

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->random(); // ['6', '4', '5']

    $collection = Collection::fromIterable(['4', '5', '6'])
        ->random(); // ['5', '6', '5']

since
~~~~~

Skip items until callback is met.

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Interface: `Sinceable`_

Signature: ``Collection::since(callable ...$callbacks);``

.. code-block:: php

    // Example 1
    // Parse the composer.json of a package and get the require-dev dependencies.
    $collection = Collection::fromResource(fopen(__DIR__ . '/composer.json', 'rb'))
        // Group items when EOL character is found.
        ->split(
            Splitable::REMOVE,
            static function (string $character): bool {
                return "\n" === $character;
            }
        )
        // Implode characters to create a line string
        ->map(
            static function (array $characters): string {
                return implode('', $characters);
            }
        )
        // Skip items until the string "require-dev" is found.
        ->since(
            static function ($line) {
                return false !== strpos($line, 'require-dev');
            }
        )
        // Skip items after the string "}" is found.
        ->until(
            static function ($line) {
                return false !== strpos($line, '}');
            }
        )
        // Re-index the keys
        ->normalize()
        // Filter out the first line and the last line.
        ->filter(
            static function ($line, $index) {
                return 0 !== $index;
            },
            static function ($line) {
                return false === strpos($line, '}');
            }
        )
        // Trim remaining results and explode the string on ':'.
        ->map(
            static function ($line) {
                return trim($line);
            },
            static function ($line) {
                return explode(':', $line);
            }
        )
        // Take the first item.
        ->pluck(0)
        // Convert to array.
        ->all();

    print_r($collection);

    // Example 2
    $input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3];

    $isGreaterThanThree = static function (int $value): bool {
        return 3 < $value;
    };

    $isGreaterThanEight = static function (int $value): bool {
        return 8 < $value;
    };

    $collection = Collection::fromIterable($input)
        ->since(
            $isGreaterThanThree,
            $isGreaterThanEight
        ); // [4, 5, 6, 7, 8, 9, 1, 2, 3]

    $collection = Collection::fromIterable($input)
        ->since(
            $isGreaterThanThree
        )
        ->since(
            $isGreaterThanEight
        ); // [9, 1, 2, 3]

slice
~~~~~

Get a slice of a collection.

Interface: `Sliceable`_

Signature: ``Collection::slice(int $offset, ?int $length = null);``

.. code-block:: php

    $collection = Collection::fromIterable(range('a', 'z'))
        ->slice(5, 5);

sort
~~~~

Sort a collection using a callback. If no callback is provided, it will sort using natural order.

By default, it will sort by values and using a callback. If you want to sort by keys, you can pass a parameter to change
the behavior or use twice the flip operation. See the example below.

Interface: `Sortable`_

Signature: ``Collection::sort(?callable $callback = null);``

.. code-block:: php

    // Regular values sorting
    $collection = Collection::fromIterable(['z', 'y', 'x'])
        ->sort();

    // Regular values sorting
    $collection = Collection::fromIterable(['z', 'y', 'x'])
        ->sort(Operation\Sortable::BY_VALUES);

    // Regular values sorting with a custom callback
    $collection = Collection::fromIterable(['z', 'y', 'x'])
        ->sort(
                Operation\Sortable::BY_VALUES,
                static function ($left, $right): int {
                    // Do the comparison here.
                    return $left <=> $right;
                }
        );

    // Regular keys sorting (no callback is needed here)
    $collection = Collection::fromIterable(['z', 'y', 'x'])
        ->sort(
                Operation\Sortable::BY_KEYS
        );

    // Regular keys sorting using flip() operations.
    $collection = Collection::fromIterable(['z', 'y', 'x'])
        ->flip() // Exchange values and keys
        ->sort() // Sort the values (which are now the keys)
        ->flip(); // Flip again to put back the keys and values, sorted by keys.

span
~~~~

Returns a tuple where first element is longest prefix (possibly empty) of elements that satisfy the callback and second element is the remainder.

Interface: `Spanable`_

Signature: ``Collection::span(callable $callback);``

.. code-block:: php

    $input = range(1, 10);

    Collection::fromIterable($input)
        ->span(fn ($x) => $x < 4); // [ [1, 2, 3], [4, 5, 6, 7, 8, 9, 10] ]

split
~~~~~

Split a collection using one or more callbacks.

A flag must be provided in order to specify whether the value used to split the collection should be added at the end
of a chunk, at the beginning of a chunk, or completely removed.

Interface: `Splitable`_

Signature: ``Collection::split(int $type = Splitable::BEFORE, callable ...$callbacks);``

.. code-block:: php

    $splitter = static function ($value): bool {
        return 0 === $value % 3;
    };

    $collection = Collection::fromIterable(range(0, 10))
        ->split(Splitable::BEFORE, $splitter); [[0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10]]

    $collection = Collection::fromIterable(range(0, 10))
        ->split(Splitable::AFTER, $splitter); [[0], [1, 2, 3], [4, 5, 6], [7, 8, 9], [10]]

    $collection = Collection::fromIterable(range(0, 10))
        ->split(Splitable::REMOVE, $splitter); [[1, 2], [4, 5], [7, 8], [10]]

tail
~~~~

Get the collection items except the first.

Interface: `Tailable`_

Signature: ``Collection::tail();``

.. code-block:: php

    Collection::fromIterable(['a', 'b', 'c'])
        ->tail(); // [1 => 'b', 2 => 'c']

tails
~~~~~

Returns the list of initial segments of its argument list, shortest last.

Interface: `Tailsable`_

Signature: ``Collection::tails();``

.. code-block:: php

    Collection::fromIterable(['a', 'b', 'c'])
        ->tails(); // [['a', 'b', 'c'], ['b', 'c'], ['c'], []]

takeWhile
~~~~~~~~~

Iterate over the collection items when the provided callback(s) are satisfied.

It stops iterating when the callback(s) are not met.

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Be careful, this operation is not the same as the ``filter`` operation.

Interface: `TakeWhileable`_

Signature: ``Collection::takeWhile(callable ...$callbacks);``

.. code-block:: php

    $isSmallerThanThree = static function (int $value): bool {
        return 3 > $value;
    };

    Collection::fromIterable([1,2,3,4,5,6,7,8,9,1,2,3])
        ->takeWhile($isSmallerThanThree); // [1,2]

transpose
~~~~~~~~~

Matrix transposition.

Interface: `Transposeable`_

Signature: ``Collection::transpose();``

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
        ->transpose();

truthy
~~~~~~

Check if the collection contains truthy values.

Interface: `Truthyable`_

Signature: ``Collection::truthy();``

unlines
~~~~~~~

Create a string from lines.

Interface: `Unlinesable`_

Signature: ``Collection::unlines();``

.. code-block:: php

    $lines = [
        'The quick brow fox jumps over the lazy dog.',
        '',
        'This is another sentence.',
    ];

    Collection::fromIterable($lines)
        ->unlines()
        ->current();

unpack
~~~~~~

Unpack items.

Interface: `Unpackable`_

Signature: ``Collection::unpack();``

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

Unpair a collection of pairs.

Interface: `Unpairable`_

Signature: ``Collection::unpair();``

.. code-block:: php

    $input = [
        'k1' => 'v1',
        'k2' => 'v2',
        'k3' => 'v3',
        'k4' => 'v4',
    ];

    $c = Collection::fromIterable($input)
        ->unpair();

    // [
    //     ['k1', 'v1'],
    //     ['k2', 'v2'],
    //     ['k3', 'v3'],
    //     ['k4', 'v4'],
    // ];

until
~~~~~

Iterate over the collection items until the provided callback(s) are satisfied.

.. warning:: The `callbacks` parameter is variadic and they are evaluated as a logical ``OR``.
             If you're looking for a logical ``AND``, you have make multiple calls to the
             same operation.

Interface: `Untilable`_

Signature: ``Collection::until(callable ...$callbacks);``

.. code-block:: php

    // The Collatz conjecture (https://en.wikipedia.org/wiki/Collatz_conjecture)
    $collatz = static function (int $value): int
    {
        return 0 === $value % 2 ?
            $value / 2:
            $value * 3 + 1;
    };

    $collection = Collection::unfold($collatz, 10)
        ->until(static function ($number): bool {
            return 1 === $number;
        });

unwindow
~~~~~~~~

Contrary of ``Collection::window()``, usually needed after a call to that operation.

Interface: `Unwindowable`_

Signature: ``Collection::unwindow();``

.. code-block:: php

    // Drop all the items before finding five 9 in a row.
    $input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 9, 9, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];

    Collection::fromIterable($input)
        ->window(4)
        ->dropWhile(
            static function (array $value): bool {
                return $value !== [9, 9, 9, 9, 9];
            }
        )
        ->unwindow()
        ->drop(1)
        ->normalize(); // [10, 11, 12, 13, 14, 15, 16, 17, 18]

unwords
~~~~~~~

Create a string from words.

Interface: `Unwordsable`_

Signature: ``Collection::unwords();``

.. code-block:: php

    $words = [
        'The',
        'quick',
        'brow',
        'fox',
        'jumps',
        'over',
        'the',
        'lazy',
        "dog.\n\nThis",
        'is',
        'another',
        'sentence.',
    ];

    Collection::fromIterable($words)
        ->unwords();

unwrap
~~~~~~

Unwrap every collection element.

Interface: `Unwrapable`_

Signature: ``Collection::unwrap();``

.. code-block:: php

     $data = [['a' => 'A'], ['b' => 'B'], ['c' => 'C']];

     $collection = Collection::fromIterable($data)
        ->unwrap();

unzip
~~~~~

Unzip a collection.

Interface: `Unzipable`_

Signature: ``Collection::unzip();``

.. code-block:: php

    $a = Collection::fromIterable(['a' => 'a', 'b' => 'b', 'c' => 'c'])
        ->zip(['d', 'e', 'f', 'g'], [1, 2, 3, 4, 5]);

    $b = Collection::fromIterable($a)
        ->unzip(); // [ ['a','b','c',null,null], ['d','e','f','g',null], [1,2,3,4,5] ]

window
~~~~~~

Loop the collection by yielding a specific window of data of a given length.

Interface: `Windowable`_

Signature: ``Collection::window(int $size);``

.. code-block:: php

     $data = range('a', 'z');

     Collection::fromIterable($data)
        ->window(2)
        ->all(); // [ ['a'], ['a', 'b'], ['b', 'c'], ['c', 'd'], ... ]

words
~~~~~

Get words from a string.

Interface: `Wordsable`_

Signature: ``Collection::words();``

.. code-block:: php

    $string = <<<'EOF'
    The quick brow fox jumps over the lazy dog.

    This is another sentence.
    EOF;

    Collection::fromString($string)
        ->words()

wrap
~~~~

Wrap every element into an array.

Interface: `Wrapable`_

Signature: ``Collection::wrap();``

.. code-block:: php

     $data = ['a' => 'A', 'b' => 'B', 'c' => 'C'];

     $collection = Collection::fromIterable($data)
        ->wrap();

zip
~~~

Zip a collection together with one or more iterables.

Interface: `Zipable`_

Signature: ``Collection::zip(iterable ...$iterables);``

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
.. _Everyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Everyable.php
.. _Explodeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Explodeable.php
.. _Falsyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Falsyable.php
.. _Filterable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Filterable.php
.. _Firstable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Firstable.php
.. _Flattenable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Flattenable.php
.. _Flipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Flipable.php
.. _array_flip(): https://php.net/array_flip
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
.. _Keyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Keyable.php
.. _Keysable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Keysable.php
.. _Lastable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Lastable.php
.. _Limitable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Limitable.php
.. _Linesable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Linesable.php
.. _Mapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Mapable.php
.. _Matchable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Matchable.php
.. _Mergeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Mergeable.php
.. _Normalizeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Normalizeable.php
.. _Nthable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Nthable.php
.. _Nullsyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Nullsyable.php
.. _Onlyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Onlyable.php
.. _Packable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Packable.php
.. _Padable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Padable.php
.. _Pairable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Pairable.php
.. _Partitionable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Partitionable.php
.. _Permutateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Permutateable.php
.. _Pluckable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Pluckable.php
.. _Prependable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Prependable.php
.. _Productable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Productable.php
.. _Randomable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Randomable.php
.. _Reductionable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reductionable.php
.. _Reverseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reverseable.php
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
.. _Windowable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Windowable.php
.. _Wordsable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Wordsable.php
.. _Wrapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Wrapable.php
.. _Zipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Zipable.php
.. _symfony/var-dumper: https://packagist.org/packages/symfony/var-dumper
.. _var_dump(): https://www.php.net/var_dump