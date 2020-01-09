API
===

append
------

Add one or more items to a collection.

Interface: `Appendable`_

Signature: ``Collection::append(...$items);``

.. code-block:: php

    $collection = Collection::with(['1', '2', '3']);

    $collection
        ->append('4'); // ['1', '2', '3', '4']

    $this
        ->append('5', '6'); // ['1', '2', '3', '5', '6']

apply
-----

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
-----

Chunk a collection of item into chunks of items of a given size.

Interface: `Chunkable`_

Signature: ``Collection::chunk(int $size);``

.. code-block:: php

    $collection = Collection::with(range(0, 10));

    $collection->chunk(2);

collapse
--------

Collapse a collection of items into a simple flat collection.

Interface: `Collapseable`_

Signature: ``Collection::collapse();``

.. code-block:: php

    $collection = Collection::with([[1,2], [3, 4]]);

    $collection->collapse();

combinate
---------

Get all the combinations of a given length of a collection of items.

Interface: `Combinateable`_

Signature: ``Collection::combinate(?int $length);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd'])
        ->combinate(3);

combine
-------

Combine a collection of items with some other keys.

Interface: `Combineable`_

Signature: ``Collection::combine(...$keys);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd'])
        ->combine('w', 'x', 'y', 'z')

cycle
-----

Cycle around a collection of items.

Interface: `Cycleable`_

Signature: ``Collection::cycle(int $length = 0);``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd'])
        ->cycle(10)

distinct
--------

Remove duplicated values from a collection.

Interface: `Distinctable`_

Signature: ``Collection::distinct();``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c', 'd', 'a'])
        ->distinct()

explode
-------

Explode a collection into subsets based on a given value.

Interface: `Explodeable`_

Signature: ``Collection::explode(...$items);``

.. code-block:: php

    $string = 'I am just a random piece of text.';

    $collection = Collection::with($string)
        ->explode('o');

filter
------

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
-------

Flatten a collection of items into a simple flat collection.

Interface: `Flattenable`_

Signature: ``Collection::flatten(int $depth = PHP_INT_MAX);``

.. code-block:: php

    $collection = Collection::with([0, [1, 2], [3, [4, [5, 6]]]])
        ->flatten();

flip
----

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
------

Remove items having specific keys.

Interface: `Forgetable`_

Signature: ``Collection::forget(...$keys);``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->forget(5, 6, 10, 15);

intersperse
-----------

Insert a given value at every n element of a collection and indices are not preserved.

Interface: `Intersperseable`_

Signature: ``Collection::intersperse($element, int $every = 1, int $startAt = 0);``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->intersperse('foo', 3);

keys
----

Get the keys of the items.

Interface: `Keysable`_

Signature: ``Collection::keys();``

.. code-block:: php

    $collection = Collection::with(range('a', 'z'))
        ->keys();

limit
-----

Limit the amount of values in the collection.

Interface: `Limitable`_

Signature: ``Collection::limit(int $limit);``

.. code-block:: php

    $fibonacci = static function ($a = 0, $b = 1): array {
        return [$b, $a + $b];
    };

    $collection = Collection::iterate($fibonacci)
        ->limit(10);

map
---

Apply one or more callbacks to a collection and use the return value.

Interface: `Mapable`_

Signature: ``Collection::map(callable ...$callbacks);``

.. code-block:: php

    $map1 = static function($value, $key) {
        return $value * 2;
    };

    $collection = Collection::with(range(1, 100))
        ->map($map1);

merge
-----

Merge one or more collection of items onto a collection.

Interface: `Mergeable`_

Signature: ``Collection::merge(...$sources);``

.. code-block:: php

    $collection = Collection::with(range(1, 10))
        ->merge(['a', 'b', 'c'])

normalize
---------

Replace, reorder and use numeric keys on a collection.

Interface: `Normalizeable`_

Signature: ``Collection::normalize();``

.. code-block:: php

    $collection = Collection::with(['a' => 'a', 'b' => 'b', 'c' => 'c'])
        ->normalize();

nth
---

Get every n-th element of a collection.

Interface: `Nthable`_

Signature: ``Collection::nth(int $step, int $offset = 0);``

.. code-block:: php

    $collection = Collection::with(range(10, 100))
        ->nth(3);

only
----

Get items having corresponding given keys.

Interface: `Onlyable`_

Signature: ``Collection::only(...$keys);``

.. code-block:: php

    $collection = Collection::with(range(10, 100))
        ->only(3, 10, 'a', 9);

pad
---

Pad a collection to the given length with a given value.

Interface: `Padable`_

Signature: ``Collection::pad(int $size, $value);``

.. code-block:: php

    $collection = Collection::with(range(1, 5))
        ->pad(10, 'foo');

permutate
---------

Find all the permutations of a collection.

Interface: `Permutateable`_

Signature: ``Collection::permutate(int $size, $value);``

.. code-block:: php

    $collection = Collection::with(['hello', 'how', 'are', 'you'])
        ->permutate();

pluck
-----

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
-------

Push an item onto the beginning of the collection.

Interface: `Prependable`_

Signature: ``Collection::prepend(...$items);``

.. code-block:: php

    $collection = Collection::with(['4', '5', '6'])
        ->prepend('1', '2', '3');

product
-------

Get the the cartesian product of items of a collection.

Interface: `Productable`_

Signature: ``Collection::product(iterable ...$iterables);``

.. code-block:: php

    $collection = Collection::with(['4', '5', '6'])
        ->product(['1', '2', '3'], ['a', 'b'], ['foo', 'bar']);

reduction
---------

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
-------

Reverse order items of a collection.

Interface: `Reverseable`_

Signature: ``Collection::reverse();``

.. code-block:: php

    $collection = Collection::with(['a', 'b', 'c'])
        ->reverse();

rsample
-------

scale
-----

skip
----

slice
-----

sort
----

split
-----

tail
----

until
-----

walk
----

zip
---

.. _Appendable: https://github.com/loophp/collection/blob/master/src/Contract/Appendable.php
.. _Applyable: https://github.com/loophp/collection/blob/master/src/Contract/Applyable.php
.. _Chunkable: https://github.com/loophp/collection/blob/master/src/Contract/Chunkable.php
.. _Collapseable: https://github.com/loophp/collection/blob/master/src/Contract/Collapseable.php
.. _Combinateable: https://github.com/loophp/collection/blob/master/src/Contract/Combinateable.php
.. _Combineable: https://github.com/loophp/collection/blob/master/src/Contract/Combineable.php
.. _Cycleable: https://github.com/loophp/collection/blob/master/src/Contract/Cycleable.php
.. _Distinctable: https://github.com/loophp/collection/blob/master/src/Contract/Distinctable.php
.. _Explodeable: https://github.com/loophp/collection/blob/master/src/Contract/Explodeable.php
.. _Filterable: https://github.com/loophp/collection/blob/master/src/Contract/Filterable.php
.. _Flattenable: https://github.com/loophp/collection/blob/master/src/Contract/Flattenable.php
.. _Flipable: https://github.com/loophp/collection/blob/master/src/Contract/Flipable.php
.. _array_flip(): https://php.net/array_flip
.. _Forgetable: https://github.com/loophp/collection/blob/master/src/Contract/Forgetable.php
.. _Intersperseable: https://github.com/loophp/collection/blob/master/src/Contract/Intersperseable.php
.. _Keysable: https://github.com/loophp/collection/blob/master/src/Contract/Keysable.php
.. _Limitable: https://github.com/loophp/collection/blob/master/src/Contract/Limitable.php
.. _Mapable: https://github.com/loophp/collection/blob/master/src/Contract/Mapable.php
.. _Mergeable: https://github.com/loophp/collection/blob/master/src/Contract/Mergeable.php
.. _Normalizeable: https://github.com/loophp/collection/blob/master/src/Contract/Normalizeable.php
.. _Nthable: https://github.com/loophp/collection/blob/master/src/Contract/Nthable.php
.. _Onlyable: https://github.com/loophp/collection/blob/master/src/Contract/Onlyable.php
.. _Padable: https://github.com/loophp/collection/blob/master/src/Contract/Padable.php
.. _Permutateable: https://github.com/loophp/collection/blob/master/src/Contract/Permutateable.php
.. _Pluckable: https://github.com/loophp/collection/blob/master/src/Contract/Pluckable.php
.. _Prependable: https://github.com/loophp/collection/blob/master/src/Contract/Prependable.php
.. _Productable: https://github.com/loophp/collection/blob/master/src/Contract/Productable.php
.. _Reductionable: https://github.com/loophp/collection/blob/master/src/Contract/Reductionable.php
.. _Reverseable: https://github.com/loophp/collection/blob/master/src/Contract/Reverseable.php
