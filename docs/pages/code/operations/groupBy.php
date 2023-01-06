<?php

declare(strict_types=1);

namespace App;

use Generator;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

$generator = static function (): Generator {
    yield 1 => 'a';

    yield 1 => 'b';

    yield 1 => 'c';

    yield 2 => 'd';

    yield 2 => 'e';

    yield 3 => 'f';
};

$groupByCallback = static fn (string $char, int $key): int => $key;

$collection = Collection::fromIterable($callback())
    ->groupBy($groupByCallback); // [1 => ['a', 'b', 'c'], 2 => ['d', 'e'], 3 => ['f']]
