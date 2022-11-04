<?php

declare(strict_types=1);

namespace App;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Operation\AbstractOperation;
use loophp\collection\Operation\Reverse;

include __DIR__ . '/../../../../vendor/autoload.php';

$square = static function ($collection): Generator {
    foreach ($collection as $item) {
        yield $item ** 2;
    }
};

$toString = static function ($collection): Generator {
    foreach ($collection as $item) {
        yield (string) $item;
    }
};

$times = new class() extends AbstractOperation {
    public function __invoke(): Closure
    {
        return static function ($collection): Generator {
            foreach ($collection as $item) {
                yield "{$item}x";
            }
        };
    }
};

Collection::fromIterable(range(1, 5))
    ->pipe($square, Reverse::of(), $toString, $times())
    ->all(); // ['25x', '16x', '9x', '4x', '1x']
