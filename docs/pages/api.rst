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

flip
----

forget
------

intersperse
-----------

keys
----

limit
-----

map
---

merge
-----

normalize
---------

nth
---

only
----

pad
---

permutate
---------

pluck
-----

prepend
-------

product
-------

reduction
---------

reverse
-------

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