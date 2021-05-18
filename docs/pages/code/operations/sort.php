<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;
use loophp\collection\Contract\Operation\Sortable;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> Regular values sorting
$collection = Collection::fromIterable(['z', 'y', 'x'])
    ->sort(); // [2 => 'x', 1 => 'y', 0 => 'z']

// Example 2 -> Regular values sorting with a custom callback
$collection = Collection::fromIterable(['z', 'y', 'x'])
    ->sort(
        Sortable::BY_VALUES,
        static fn ($left, $right): int => $left <=> $right
    ); // [2 => 'x', 1 => 'y', 0 => 'z']

// Example 3 -> Regular keys sorting (no callback is needed here)
$collection = Collection::fromIterable([3 => 'z', 2 => 'y', 1 => 'x'])
    ->sort(Sortable::BY_KEYS); // [1 => 'x', 2 => 'y', 3 => 'z']

// Example 4 -> Regular keys sorting using the flip() operation twice
$collection = Collection::fromIterable([3 => 'z', 2 => 'y', 1 => 'x'])
    ->flip() // Exchange values and keys
    ->sort() // Sort the values (which are now the keys)
    ->flip(); // Flip again to put back the keys and values, sorted by keys.
// [1 => 'x', 2 => 'y', 3 => 'z']
