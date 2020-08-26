<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Limit extends AbstractOperation implements Operation
{
    public function __construct(int $limit, int $offset = 0)
    {
        $this->storage = [
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator, int $limit, int $offset): Generator {
                if (0 === $limit) {
                    return yield from [];
                }

                return yield from new LimitIterator($iterator, $offset, $limit);
            };
    }
}
