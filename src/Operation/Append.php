<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Append extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$items
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, T>
             */
            static fn (...$items): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<int|TKey, T>
                 */
                static function (Iterator $iterator) use ($items): Generator {
                    foreach ($iterator as $key => $value) {
                        yield $key => $value;
                    }

                    foreach ($items as $key => $item) {
                        yield $key => $item;
                    }
                };
    }
}
