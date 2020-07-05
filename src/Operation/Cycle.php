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
    public function __construct(?int $length = null)
    {
        $this->storage['length'] = $length ?? 0;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, int $length): Generator {
            if (0 === $length) {
                return yield from [];
            }

            $iterator = new LimitIterator(
                new InfiniteIterator(
                    new IterableIterator($collection)
                ),
                0,
                $length
            );

            foreach ($iterator as $key => $value) {
                yield $key => $value;
            }
        };
    }
}
