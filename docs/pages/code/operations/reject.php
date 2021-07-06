<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$divisibleBy2 = static fn ($value): bool => 0 === $value % 2;
$divisibleBy3 = static fn ($value): bool => 0 === $value % 3;
$divisibleBy4 = static fn ($value): bool => 0 === $value % 4;

$collection = Collection::fromIterable(range(1, 10))
    ->reject($divisibleBy2); // [1, 3, 5, 7, 9]

$collection = Collection::fromIterable(range(1, 10))
    ->reject($divisibleBy2, $divisibleBy3, $divisibleBy4); // [1, 5, 7]
