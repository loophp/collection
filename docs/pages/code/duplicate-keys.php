<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$frequency = Collection::fromString('aaaaabbbbcccddddeeeee')
    ->frequency();

// Method 1 -> wrapped collection
$wrapped = $frequency
    ->wrap() // Wrap each result into an array
    ->all(); // Convert to regular array

/**
 * [
 *   [5 => 'a'],
 *   [4 => 'b'],
 *   [3 => 'c'],
 *   [4 => 'd'],
 *   [5 => 'e'],
 * ].
 */

// Method 2 -> normalized collection
$normalized = $frequency
    ->all(); // Convert to regular array and replace keys with numerical indexes

/**
 * [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd', 4 => 'e'].
 *
 * Note this is not useful for our frequency analysis scenario,
 * but it can be useful in cases where we don't care about the
 * key values, like in the example below.
 */
$collection = Collection::fromIterable(range(1, 10))
    ->filter(static fn ($value): bool => $value % 3 === 0);

$filtered = $collection->all(false); // [2 => 3, 5 => 6, 8 => 9]
$filteredNormalized = $collection->all(); // [0 => 3, 1 => 6, 2 => 9]

// Method 3 -> consuming the collection as an iterator
foreach ($frequency as $k => $v) {
    var_dump("({$k}, {$v})");
}

/**
 * "(5, a)"
 * "(4, b)"
 * "(3, c)"
 * "(4, d)"
 * "(5, e)".
 */
