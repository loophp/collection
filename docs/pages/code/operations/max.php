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

$callback = static fn (stdClass $left, stdClass $right): stdClass => max($left->age, $right->age);

$result = Collection::fromIterable([1, 4, 3, 0, 2])
    ->max()      // [1 => 4]
    ->current(); // 4

$result = Collection::fromIterable([1, 4, null, 0, 2])
    ->max()
    ->current(); // 4

$result = Collection::fromIterable([(object) ['id' => 2, 'age' => 5], (object) ['id' => 1, 'age' => 10]])
    ->max($callback)
    ->current(); // (object) ['id' => 1, 'age' => 10]
