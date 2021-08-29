<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$input = range('a', 'c');

Collection::fromIterable(range('a', 'c'))
    ->inits(); // [[], [[0, 'a']], [[0, 'a'], [1, 'b']], [[0, 'a'], [1, 'b'], [2, 'c']]]

Collection::fromIterable(array_combine(range('A', 'C'), $input))
    ->inits(); // [[], [['A', 'a']], [['A', 'a'], ['B', 'b']], [['A', 'a'], ['B', 'b'], ['C', 'c']]]

// To get only the values:
Collection::fromIterable($input)
    ->inits()
    ->map(static fn (array $data): array => array_column($data, 1));
    // [[], ['a'], ['a', 'b'], ['a', 'b', 'c']]
