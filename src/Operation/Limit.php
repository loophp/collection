<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
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

    /**
     * @return Closure(\Iterator<TKey, T>, int, int): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, int $limit, int $offset): Generator {
                yield from new LimitIterator($iterator, $offset, $limit);
            };
    }
}
