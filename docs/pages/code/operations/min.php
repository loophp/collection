<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;
use stdClass;

include __DIR__ . '/../../../../vendor/autoload.php';

$callback = static fn (stdClass $left, stdClass $right): stdClass => min($left->age, $right->age);

$result = Collection::fromIterable([1, 4, 3, 0, 2])
    ->min()      // [4 => 0]
    ->current(); // 0

$result = Collection::fromIterable([1, 4, null, 0, 2])
    ->min()
    ->current(); // null

$result = Collection::fromIterable([(object) ['id' => 2, 'age' => 5], (object) ['id' => 1, 'age' => 10]])
    ->min($callback)
    ->current(); // (object) ['id' => 2, 'age' => 5]
