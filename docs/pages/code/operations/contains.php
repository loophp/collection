<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$result = Collection::fromIterable(range('a', 'c'))
    ->contains('d'); // false

$result = Collection::fromIterable(range('a', 'c'))
    ->contains('a', 'z'); // true

$result = Collection::fromIterable(['a' => 'b', 'c' => 'd'])
    ->contains('d'); // true
