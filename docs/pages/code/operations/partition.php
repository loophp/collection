<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use Closure;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$isGreaterThan = static fn (int $left): Closure => static fn (int $right): bool => $left < $right;

$input = array_combine(range('a', 'l'), [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3]);

// Example 1 - Retrieve the left and right groups
[$left, $right] = Collection::fromIterable($input)
    ->partition(
        $isGreaterThan(5)
    )
    ->all();

// Numbers that are greater than 5
print_r($left->all());
/*
[
    ['f', 6],
    ['g', 7],
    ['h', 8],
    ['i', 9],
]
 */

// Numbers that are not greater than 5
print_r($right->all());
/*
[
    ['a', 1],
    ['b', 2],
    ['c', 3],
    ['d', 4],
    ['e', 5],
    ['j', 1],
    ['k', 2],
    ['l', 3],
]
 */

 // Example 2 - Retrieve the first group
$left = Collection::fromIterable($input)
    ->partition(
        $isGreaterThan(5)
    )
    ->first()
    ->current();

// Numbers that are greater than 5
print_r($left->all());
/*
[
['f', 6],
['g', 7],
['h', 8],
['i', 9],
]
 */
