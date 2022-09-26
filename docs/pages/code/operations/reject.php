<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$divisibleBy2 = static fn ($value): bool => 0 === $value % 2;
$divisibleBy3 = static fn ($value): bool => 0 === $value % 3;

// Reject values divisible by 2
$collection = Collection::fromIterable(range(1, 10))
    ->reject($divisibleBy2); // [1, 3, 5, 7, 9]

// Reject values divisible by 2 or 3
$collection = Collection::fromIterable(range(1, 10))
    ->reject($divisibleBy2, $divisibleBy3); // [1, 5, 7]

// Reject values not divisible by 2 and then by 3
$collection = Collection::fromIterable(range(1, 10))
    ->reject($divisibleBy2)
    ->reject($divisibleBy3); // [1, 5, 7]
