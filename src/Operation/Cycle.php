<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
use LimitIterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

final class Cycle extends AbstractOperation implements Operation
{
    public function __construct(int $length = 0)
    {
        $this->storage['length'] = $length;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, int $length): Generator {
            $iterator = new LimitIterator(
                new InfiniteIterator(
                    new IterableIterator($collection)
                ),
                0,
                $length
            );

            foreach ($iterator as $value) {
                yield $value;
            }
        };
    }
}
