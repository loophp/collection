<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable([1, 2, 3])
    ->jsonSerialize(); // [1, 2, 3]

Collection::fromIterable([1, 2, 3])
    ->filter(static fn (int $val): bool => $val % 2 !== 0)
    ->jsonSerialize(); // [0 => 1, 2 => 3]

Collection::fromIterable(['foo' => 1, 'bar' => 2])
    ->jsonSerialize(); // ['foo' => 1, 'bar' => 2]
