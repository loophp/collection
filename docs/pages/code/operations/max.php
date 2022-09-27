<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

use const PHP_INT_MAX;

include __DIR__ . '/../../../../vendor/autoload.php';

$result = Collection::fromIterable([1, 4, 3, 0, 2])
    ->max(); // 4

$result = Collection::fromIterable([1, 4, null, 0, 2])
    ->max(); // 4

$result = Collection::empty()
    ->max(PHP_INT_MAX); // PHP_INT_MAX
