<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$callback = static fn (int $carry, int $item): int => $carry + $item;

$collection = Collection::fromIterable(range(1, 5))
    ->foldLeft($callback, 0); // 15

$collection = Collection::empty()
    ->foldLeft($callback, 'foo'); // 'foo'
