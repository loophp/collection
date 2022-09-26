<?php

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Does it contains the letter 'd' ?
$result = Collection::fromIterable(range('a', 'c'))
    ->contains('d'); // false

// Does it contains the letter 'a' or 'z' ?
$result = Collection::fromIterable(range('a', 'c'))
    ->contains('a', 'z'); // true

// Does it contains the letter 'd' ?
$result = Collection::fromIterable(['a' => 'b', 'c' => 'd'])
    ->contains('d'); // true
