<?php

declare(strict_types=1);

namespace App;

use Closure;
use Generator;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\AbstractOperation;

include __DIR__ . '/../../../../vendor/autoload.php';

$multiplyBy = new class() extends AbstractOperation {
    public function __invoke(): Closure
    {
        return static function (int $multiplier): Closure {
            return static function (CollectionInterface $collection) use ($multiplier): Generator {
                foreach ($collection as $key => $item) {
                    yield $key => ($item * $multiplier);
                }
            };
        };
    }
};

$c = Collection::fromIterable(range(1, 5))
    ->with($multiplyBy, [3])
    ->all(); // [3, 6, 9, 12, 15]
