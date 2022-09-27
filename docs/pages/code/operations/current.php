<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable(['a', 'b', 'c', 'd'])->current(); // Return 'a'
Collection::fromIterable(['a', 'b', 'c', 'd'])->current(0); // Return 'a'
Collection::fromIterable(['a', 'b', 'c', 'd'])->current(1); // Return 'b'
Collection::fromIterable(['a', 'b', 'c', 'd'])->current(10); // Return null
Collection::fromIterable(['a', 'b', 'c', 'd'])->current(10, 'unavailable'); // Return 'unavailable'
