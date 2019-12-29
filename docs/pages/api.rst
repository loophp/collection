API
===

append
------

.. code-block:: php

    $collection = Collection::with(['1', '2', '3']);

    $collection
        ->append('4'); // ['1', '2', '3', '4']

    $this
        ->append('5', '6'); // ['1', '2', '3', '5', '6']


apply
-----

chunk
-----

collapse
--------

combine
-------

distinct
--------

explode
-------

filter
------

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

pluck
-----

prepend
-------

rebase
------

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
