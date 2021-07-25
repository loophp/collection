<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use ArrayIterator;
use loophp\collection\Collection;
use loophp\collection\Operation\Filter;

include __DIR__ . '/../../../../vendor/autoload.php';

$input = [1, 2, 3, 4];
$even = static fn (int $value): bool => $value % 2 === 0;

// Standalone usage
$filtered = Filter::of()($even)(new ArrayIterator($input));

print_r(iterator_to_array($filtered)); // [2, 4]

// Usage via Collection object
$filtered = Collection::fromIterable($input)->filter($even);

print_r($filtered->all()); // [2, 4]
