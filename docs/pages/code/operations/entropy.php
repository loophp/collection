<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$collection = Collection::fromIterable(['a'])
    ->entropy(); // [0]

$collection = Collection::fromIterable(['a', 'b'])
    ->entropy(); // [0, 1]

$collection = Collection::fromIterable(['a', 'b', 'a'])
    ->entropy(); // [0, 1, 0.9182958340544896]
