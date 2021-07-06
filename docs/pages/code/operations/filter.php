<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

include __DIR__ . '/../vendor/autoload.php';

use loophp\collection\Collection;

$divisibleBy3 = static fn ($value): bool => 0 === $value % 3;
$divisibleBy5 = static fn ($value): bool => 0 === $value % 5;

$collection = Collection::fromIterable(range(1, 10))
    ->filter($divisibleBy3); // [3, 6, 9]

$collection = Collection::fromIterable(range(1, 10))
    ->filter($divisibleBy3, $divisibleBy5); // [3, 5, 6, 0, 10]
