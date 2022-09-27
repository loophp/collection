<?php

declare(strict_types=1);

namespace App;

use Generator;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> string keys
$collection = Collection::fromIterable(['a' => 10, 'b' => 100, 'c' => 1000])
    ->normalize();  // [0 => 10, 1 => 100, 2 => 1000]

// Example 2 -> duplicate keys
$generator = static function (): Generator {
    yield 1 => 'a';

    yield 2 => 'b';

    yield 1 => 'c';

    yield 3 => 'd';
};

$collection = Collection::fromIterable($generator())
    ->normalize(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd']

// Example 3 -> "missing" numeric keys
$collection = Collection::fromIterable(range(1, 5))
    ->filter(static fn (int $val): bool => $val % 2 === 0) // [1 => 2, 3 => 4]
    ->normalize(); // [0 => 2, 1 => 4]
