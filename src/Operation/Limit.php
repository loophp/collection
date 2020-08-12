<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Limit extends AbstractLazyOperation implements LazyOperation
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
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, int $limit, int $offset): Generator {
                return yield from new LimitIterator($iterator, $offset, $limit);
            };
    }
}
