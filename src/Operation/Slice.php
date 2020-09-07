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
final class Slice extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(int=): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(int=): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $offset): Closure {
                return
                    /**
                     * @psalm-param int $length
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (int $length = -1) use ($offset): Closure {
                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator) use ($offset, $length): Generator {
                                /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $skip */
                                $skip = Drop::of()($offset);

                                if (-1 === $length) {
                                    return yield from $skip($iterator);
                                }

                                return yield from Compose::of()($skip, Limit::of()($length)(0))($iterator);
                            };
                    };
            };
    }
}
