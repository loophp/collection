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
     * @psalm-return Closure(int): Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $seed): Closure {
                return
                    /**
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (int $size) use ($seed): Closure {
                        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                        $pipe = Pipe::of()(
                            Shuffle::of()($seed),
                            Limit::of()($size)(0)
                        );

                        // Point free style.
                        return $pipe;
                    };
            };
    }
}
