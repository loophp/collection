API
===

Static constructors
-------------------

empty
~~~~~

Create an empty Collection.

.. code-block:: php

    $collection = Collection::empty();

iterate
~~~~~~~

Iterate over a callback and use the callback results to build a collection.

Signature: ``Collection::iterate(callable $callback, ...$parameters);``

.. warning:: The callback return values are reused as callback arguments at the next callback call.

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    $collection = Collection::iterate($fibonacci)
        ->limit(10);

Another example

.. code-block:: php

    $even = Collection::iterate(static function ($carry) {return $carry + 2;}, -2);
    $odd = Collection::iterate(static function ($carry) {return $carry + 2;}, -1);
    // Is the same as
    $even = Collection::range(0, \INF, 2);
    $odd = Collection::range(1, \INF, 2);


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

    $even = Collection::iterate(static function ($carry) {return $carry + 2;}, -2);
    $odd = Collection::iterate(static function ($carry) {return $carry + 2;}, -1);
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

with
~~~~

Create a collection with the provided data.

Signature: ``Collection::with($data = [], ...$parameters);``

.. code-block:: php

    // With an iterable
    $collection = Collection::with(['a', 'b']);

    // With a string
    $collection = Collection::with('string');

    $callback = static function () {
        yield 'a';
        yield 'b';
        yield 'c';
    };

    // With a callback
    $collection = Collection::with($callback);

    // With a resource/stream
    $collection = Collection::with(fopen( __DIR__ . '/vendor/autoload.php', 'r'));


Methods (operations)
--------------------

Operations always returns a new collection object.

append
~~~~~~

Add one or more items to a collection.

Interface: `Appendable`_

Signature: ``Collection::append(...$items);``

.. code-block:: php

    $collection = Collection::with(['1', '2', '3']);

    $collection
        ->append('4')
        ->append('5', '6');

apply
~~~~~

Execute a callback for each element of the collection without
altering the collection item itself.

If the callback does not return `true` then it stops.

Interface: `Applyable`_

Signature: ``Collection::apply(...$callbacks);``

.. code-block:: php

    $callback = static function ($value, $key): bool
        {
            var_dump('Value is: ' . $value . ', key is: ' . $key);

            return true;
        };

    $collection = Collection::with(['1', '2', '3']);

    $collection
        ->apply($callback);

chunk
~~~~~

Chunk a collection of item into chunks of items of a given size.

Interface: `Chunkable`_

Signature: ``Collection::chunk(int $size);``

.. code-block:: php

    $collection = Collection::with(range(0, 10));

    $collection->chunk(2);

collapse
~~~~~~~~

Collapse a collection of items into a simple flat collection.

Interface: `Collapseable`_

Signature: ``Collection::collapse();``

.. code-block:: php

    $collection = Collection::with([[1,2], [3, 4]]);

    $collection->collapse();

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

    $result = Collection::with($records)
        ->column('first_name');

combinate
~~~~~~~~~

Get all the combinations of a given length of a collection of items.

Interface: `Combinateable`_

Signature: ``Collection::combinate(?int $length);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd'])
        ->combinate(3);

combine
~~~~~~~

Combine a collection of items with some other keys.

Interface: `Combineable`_

Signature: ``Collection::combine(...$keys);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd'])
        ->combine('w', 'x', 'y', 'z')

cycle
~~~~~

Cycle around a collection of items.

Interface: `Cycleable`_

Signature: ``Collection::cycle(int $length = 0);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd'])
        ->cycle(10)

distinct
~~~~~~~~

Remove duplicated values from a collection.

Interface: `Distinctable`_

Signature: ``Collection::distinct();``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd', 'a'])
        ->distinct()

explode
~~~~~~~

Explode a collection into subsets based on a given value.

Interface: `Explodeable`_

Signature: ``Collection::explode(...$items);``

.. code-block:: php

    $string = 'I am just a random piece of text.';

    $collection = Collection::with($string)
        ->explode('o');

filter
~~~~~~

Filter collection items based on one or more callbacks.

Interface: `Filterable`_

Signature: ``Collection::filter(callable ...$callbacks);``

.. code-block:: php

    $callback = static function($value): bool {
        return 0 === $value % 3;
    };

    $collection = Collection::with(range(1, 100))
        ->filter($callback);

flatten
~~~~~~~

Flatten a collection of items into a simple flat collection.

Interface: `Flattenable`_

Signature: ``Collection::flatten(int $depth = PHP_INT_MAX);``

.. code-block:: php

    $collection = Collection::with([0, [1, 2], [3, [4, [5, 6]]]])
        ->flatten();

flip
~~~~

Flip keys and items in a collection.

Interface: `Flipable`_

Signature: ``Collection::flip(int $depth = PHP_INT_MAX);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'a'])
        ->flip();

.. tip:: array_flip() and Collection::flip() can behave different, check the following examples.

When using regular arrays, `array_flip()`_ can be used to remove duplicates (dedup-licate an array).

.. code-block:: php

    $dedupArray = array_flip(array_flip(['a', 'b', 'c', 'd', 'a']));

This example will return ``['a', 'b', 'c', 'd']``.

However, when using a collection:

.. code-block:: php

    $dedupCollection = Collection::with(['a', 'b', 'c', 'd', 'a'])
        ->flip()
        ->flip()
        ->all();

This example will return ``['a', 'b', 'c', 'd', 'a']``.

forget
~~~~~~

Remove items having specific keys.

Interface: `Forgetable`_

Signature: ``Collection::forget(...$keys);``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->forget(5, 6, 10, 15);

frequency
~~~~~~~~~

Calculate the frequency of the values, frequencies are stored in keys.

Values can be anything (object, scalar, ... ).

Interface: `Frequencyable`_

Signature: ``Collection::frequency();``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'b', 'c', 'c')
        ->frequency()
        ->all(); // [1 => 'a', 2 => 'b', 3 => 'c'];

group
~~~~~

Group items, the key used to group items can be customized in a callback.
By default it's the key is the item's key.

Interface: `Groupable`_

Signature: ``Collection::group(callable $callable = null);``

.. code-block:: php

    $callback = static function () {
            yield 1 => 'a';

            yield 1 => 'b';

            yield 1 => 'c';

            yield 2 => 'd';

            yield 2 => 'e';

            yield 3 => 'f';
    };

    $collection = Collection::with($callback)
        ->group();

intersperse
~~~~~~~~~~~

Insert a given value at every n element of a collection and indices are not preserved.

Interface: `Intersperseable`_

Signature: ``Collection::intersperse($element, int $every = 1, int $startAt = 0);``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->intersperse('foo', 3);

keys
~~~~

Get the keys of the items.

Interface: `Keysable`_

Signature: ``Collection::keys();``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->keys();

limit
~~~~~

Limit the amount of values in the collection.

Interface: `Limitable`_

Signature: ``Collection::limit(int $limit);``

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    $collection = Collection::iterate($fibonacci)
        ->limit(10);

loop
~~~~

Loop over the values of the collection indefinitely, in a cyclic way.

Interface: `Loopable`_

Signature: ``Collection::loop();``

.. code-block:: php

    $diceData = range(1, 6);

    // Simulate a dice throw.
    $randomDiceValue = Collection::with($data)
        ->loop()
        ->limit(random_int(0, 1000))
        ->last();

map
~~~

Apply one or more supplied callbacks to every item of a collection and use the return value.

.. warning:: Unlike the Collection::walk() operation, keys are not preserved!

Interface: `Mapable`_

Signature: ``Collection::map(callable ...$callbacks);``

.. code-block:: php

    $mapper = static function($value, $key) {
        return $value * 2;
    };

    $collection = Collection::with(range(1, 100))
        ->map($mapper);

merge
~~~~~

Merge one or more collection of items onto a collection.

Interface: `Mergeable`_

Signature: ``Collection::merge(...$sources);``

.. code-block:: php

    $collection = Collection::with(range(1, 10))
        ->merge(['a', 'b', 'c'])

normalize
~~~~~~~~~

Replace, reorder and use numeric keys on a collection.

Interface: `Normalizeable`_

Signature: ``Collection::normalize();``

.. code-block:: php

    $collection = Collection::with(['a' => 'a', 'b' => 'b', 'c' => 'c'])
        ->normalize();

nth
~~~

Get every n-th element of a collection.

Interface: `Nthable`_

Signature: ``Collection::nth(int $step, int $offset = 0);``

.. code-block:: php

    $collection = Collection::with(range(10, 100))
        ->nth(3);

only
~~~~

Get items having corresponding given keys.

Interface: `Onlyable`_

Signature: ``Collection::only(...$keys);``

.. code-block:: php

    $collection = Collection::with(range(10, 100))
        ->only(3, 10, 'a', 9);

pad
~~~

Pad a collection to the given length with a given value.

Interface: `Padable`_

Signature: ``Collection::pad(int $size, $value);``

.. code-block:: php

    $collection = Collection::with(range(1, 5))
        ->pad(10, 'foo');

permutate
~~~~~~~~~

Find all the permutations of a collection.

Interface: `Permutateable`_

Signature: ``Collection::permutate(int $size, $value);``

.. code-block:: php

    $collection = Collection::with(['hello', 'how', 'are', 'you'])
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

    $collection = Collection::iterate($fibonacci)
        ->limit(10)
        ->pluck(0);

prepend
~~~~~~~

Push an item onto the beginning of the collection.

Interface: `Prependable`_

Signature: ``Collection::prepend(...$items);``

.. code-block:: php

    $collection = Collection::with(['4', '5', '6'])
        ->prepend('1', '2', '3');

product
~~~~~~~

Get the the cartesian product of items of a collection.

Interface: `Productable`_

Signature: ``Collection::product(iterable ...$iterables);``

.. code-block:: php

    $collection = Collection::with(['4', '5', '6'])
        ->product(['1', '2', '3'], ['a', 'b'], ['foo', 'bar']);

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

    $collection = Collection::with(['a', 'b', 'c'])
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

since
~~~~~

Skip items until callback is met.

Interface: `Sinceable`_

Signature: ``Collection::since(callable ...$callbacks);``

.. code-block:: php

    // Parse the composer.json of a package and get the require-dev dependencies.
    $collection = Collection::with(fopen(__DIR__ . '/composer.json', 'rb'))
        // Group items when EOL character is found.
        ->split(
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

skip
~~~~

Skip the n items of a collection.

Interface: `Skipable`_

Signature: ``Collection::skip(int ...$counts);``

.. code-block:: php

    $collection = Collection::with(range(10, 20))
        ->skip(2);

slice
~~~~~

Get a slice of a collection.

Interface: `Sliceable`_

Signature: ``Collection::slice(int $offset, ?int $length = null);``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->slice(5, 5);

sort
~~~~

Sort a collection using a callback.

If no callback is provided, it will sort using natural order.

Interface: `Sortable`_

Signature: ``Collection::sort(?callable $callback = null);``

.. code-block:: php

    $collection = Collection::with(['z', 'y', 'x'])
        ->sort();

split
~~~~~

Split a collection using a callback.

Interface: `Splitable`_

Signature: ``Collection::split(callable ...$callbacks);``

.. code-block:: php

    $splitter = static function ($value, $key) {
        return 0 === $value % 3;
    };

    $collection = Collection::with(range(0, 20))
        ->split($splitter);

tail
~~~~

Get last collection items of a collection.

Interface: `Tailable`_

Signature: ``Collection::tail(int $length = 1);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c'])
        ->tail(2);

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

    $result = Collection::with($records)
        ->transpose();

until
~~~~~

Limit a collection using a callback.

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

    $collection = Collection::iterate($collatz, 10)
        ->until(static function ($number): bool {
            return 1 === $number;
        });

walk
~~~~

Apply one or more supplied callbacks to every item of a collection and use the return value.

.. warning:: Unlike the Collection::map() operation, keys are preserved!

Interface: `Walkable`_

Signature: ``Collection::walk(callable ...$callbacks);``

.. code-block:: php

    $walker = static function($value, $key) {
        return $value * 2;
    };

    $collection = Collection::with(range(10, 20))
        ->walk($walker);

window
~~~~~~

Loop the collection by yielding a specific window of data of a given length.

Interface: `Windowable`_

Signature: ``Collection::window(int ...$length);``

.. code-block:: php

     $data = range('a', 'z');

     $collection = Collection::with($data)
        ->window(2, 3)
        ->all();

zip
~~~

Zip a collection together with one or more iterables.

Interface: `Zipable`_

Signature: ``Collection::zip(iterable ...$iterables);``

.. code-block:: php

    $even = Collection::range(0, INF, 2);
    $odd = Collection::range(1, INF, 2);

    $positiveIntegers = Collection::with($even)
        ->zip($odd)
        ->limit(100)
        ->flatten();

Methods (transformations)
-------------------------

Transformations might returns something different from a collection.

all
~~~

Interface: `Allable`_

contains
~~~~~~~~

Interface: `Containsable`_

falsy
~~~~~

Interface: `Falsyable`_

first
~~~~~

Interface: `Firstable`_

foldLeft
~~~~~~~~

Interface: `FoldLeftable`_

foldRight
~~~~~~~~~

Interface: `FoldRightable`_

get
~~~

Interface: `Getable`_

implode
~~~~~~~

Interface: `Implodeable`_

last
~~~~

Interface: `Lastable`_

nullsy
~~~~~~

Interface: `Nullsyable`_

reduce
~~~~~~

Interface: `Reduceable`_

run
~~~

Interface: `Runable`_

transform
~~~~~~~~~

Interface: `Transformable`_

truthy
~~~~~~

Interface: `Truthyable`_

.. _Allable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Allable.php
.. _Appendable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Appendable.php
.. _Applyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Applyable.php
.. _Chunkable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Chunkable.php
.. _Collapseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Collapseable.php
.. _Columnable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Columnable.php
.. _Combinateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Combinateable.php
.. _Combineable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Combineable.php
.. _Containsable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Containsable.php
.. _Cycleable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Cycleable.php
.. _Distinctable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Distinctable.php
.. _Explodeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Explodeable.php
.. _Falsyable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Falsyable.php
.. _Filterable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Filterable.php
.. _Firstable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Firstable.php
.. _Flattenable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Flattenable.php
.. _Flipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Flipable.php
.. _array_flip(): https://php.net/array_flip
.. _FoldLeftable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/FoldLeftable.php
.. _FoldRightable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/FoldRightable.php
.. _Forgetable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Forgetable.php
.. _Frequencyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Frequencyable.php
.. _Getable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Getable.php
.. _Groupable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Groupable.php
.. _Implodeable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Implodeable.php
.. _Intersperseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Intersperseable.php
.. _Keysable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Keysable.php
.. _Lastable: https://github.com/loophp/collection/blob/master/src/Contract/Tranformation/Lastable.php
.. _Limitable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Limitable.php
.. _Loopable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Loopable.php
.. _Mapable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Mapable.php
.. _Mergeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Mergeable.php
.. _Normalizeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Normalizeable.php
.. _Nthable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Nthable.php
.. _Nullsyable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Nullsyable.php
.. _Onlyable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Onlyable.php
.. _Padable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Padable.php
.. _Permutateable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Permutateable.php
.. _Pluckable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Pluckable.php
.. _Prependable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Prependable.php
.. _Productable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Productable.php
.. _Reduceable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Reduceable.php
.. _Reductionable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reductionable.php
.. _Reverseable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Reverseable.php
.. _Runable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Runable.php
.. _Scaleable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Scaleable.php
.. _Skipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Skipable.php
.. _Sinceable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sinceable.php
.. _Sliceable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sliceable.php
.. _Sortable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Sortable.php
.. _Splitable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Splitable.php
.. _Tailable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Tailable.php
.. _Transformable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Transformable.php
.. _Transposeable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Transposeable.php
.. _Truthyable: https://github.com/loophp/collection/blob/master/src/Contract/Transformation/Truthyable.php
.. _Untilable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Untilable.php
.. _Walkable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Walkable.php
.. _Windowable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Windowable.php
.. _Zipable: https://github.com/loophp/collection/blob/master/src/Contract/Operation/Zipable.php
