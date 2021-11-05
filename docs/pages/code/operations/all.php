<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use Generator;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> usage with "list" collection
$generator = static function (): Generator {
    yield 0 => 'a';

    yield 1 => 'b';

    yield 0 => 'c';

    yield 2 => 'd';
};

$collection = Collection::fromIterable($generator());
print_r($collection->all(false)); // [0 => 'c', 1 => 'b', 2 => 'd']

$collection = Collection::fromIterable($generator());
print_r($collection->all()); // ['a', 'b', 'c', 'd']

// Example 2 -> usage with "map" collection
$collection = Collection::fromIterable(['foo' => 1, 'bar' => 2]);

print_r($collection->all(false)); // ['foo' => 1, 'bar' => 2]
print_r($collection->all()); // [1, 2]
