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
final class Random extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $size): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($size): Generator {
                        return yield from (Compose::of()(
                            Shuffle::of(),
                            Limit::of()($size)(0)
                        )($iterator));
                    };
            };
    }
}
