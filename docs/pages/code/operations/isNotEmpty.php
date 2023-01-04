<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

Collection::fromIterable(range('a', 'c'))
    ->isNotEmpty(); // true

Collection::fromIterable([])
    ->isNotEmpty(); // false

Collection::fromIterable([null])
    ->isNotEmpty(); // true
