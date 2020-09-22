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
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $compose */
                $compose = Compose::of()(
                    Shuffle::of(),
                    Limit::of()($size)(0)
                );

                // Point free style.
                return $compose;
            };
    }
}
