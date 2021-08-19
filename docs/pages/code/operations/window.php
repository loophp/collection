<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$data = range('a', 'e');

Collection::fromIterable($data)
    ->window(0); // [['a'], ['b'], ['c'], ['d'], ['e']]

Collection::fromIterable($data)
    ->window(1); // [['a'], ['a', 'b'], ['b', 'c'], ['c', 'd'], ['d', 'e']]

Collection::fromIterable($data)
    ->window(2); // [['a'], ['a', 'b'], ['a', 'b', 'c'], ['b', 'c', 'd'], ['c', 'd', 'e']]

Collection::fromIterable($data)
    ->window(-1); // [['a'], ['a', 'b'], ['a', 'b', 'c'], ['a', 'b', 'c', 'd'], ['a', 'b', 'c', 'd', 'e']]
