<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable(range('a', 'c'))
    ->isEmpty(); // false

Collection::fromIterable([])
    ->isEmpty(); // true

Collection::fromIterable([null])
    ->isEmpty(); // false
