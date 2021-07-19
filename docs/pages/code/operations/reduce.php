<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$callback = static fn (int $carry, int $item): int => $carry + $item;

$collection = Collection::empty()
    ->reduce($callback); // []

$collection = Collection::fromIterable(range(1, 5))
    ->reduce($callback, 0); // [4 => 15]
