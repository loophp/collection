<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$collection = Collection::fromIterable(['a'])
    ->dispersion(); // [0]

$collection = Collection::fromIterable(['a', 'b'])
    ->dispersion(); // [0, 1]

$collection = Collection::fromIterable(['a', 'b', 'a'])
    ->dispersion(); // [0, 1, 1]

$collection = Collection::fromIterable(['a', 'b', 'b'])
    ->dispersion(); // [0, 1, .5]
