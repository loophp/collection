<?php

declare(strict_types=1);

namespace App;

include __DIR__ . '/../vendor/autoload.php';

use Closure;
use loophp\collection\Collection;

$isGreaterThan = static fn (int $left): Closure => static fn (int $right): bool => $left < $right;

$input = array_combine(range('a', 'l'), [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3]);

$collection = Collection::fromIterable($input)
    ->partition(
        $isGreaterThan(5),
        $isGreaterThan(3)
    );

// Result
/*
[
    [
        ['d', 4],
        ['e', 5],
        ['f', 6],
        ['g', 7],
        ['h', 8],
        ['i', 9],
    ],
    [
        ['a', 1],
        ['b', 2],
        ['c', 3],
        ['j', 1],
        ['k', 2],
        ['l', 3],
    ],
]
 */
