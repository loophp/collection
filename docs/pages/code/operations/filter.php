<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$divisibleBy2 = static fn ($value): bool => 0 === $value % 2;
$divisibleBy3 = static fn ($value): bool => 0 === $value % 3;

$collection = Collection::fromIterable(range(1, 10))
    ->filter($divisibleBy3); // [3, 6, 9]

$collection = Collection::fromIterable(range(1, 10))
    ->filter($divisibleBy2, $divisibleBy3); // [2, 3, 4, 6, 8, 9, 10]

$collection = Collection::fromIterable(range(1, 10))
    ->filter($divisibleBy2)
    ->filter($divisibleBy3); // [6]
