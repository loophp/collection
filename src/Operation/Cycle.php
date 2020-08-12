<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
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
final class Cycle extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(?int $length = null)
    {
        $this->storage['length'] = $length ?? 0;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, int $length): Generator {
                if (0 === $length) {
                    return yield from [];
                }

                return yield from new LimitIterator(
                    new InfiniteIterator($iterator),
                    0,
                    $length
                );
            };
    }
}
