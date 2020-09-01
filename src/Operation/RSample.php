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
final class RSample extends AbstractOperation
{
    /**
     * @return Closure(float): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (float $probability): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($probability): Generator {
                        $callback = static function (float $probability): Closure {
                            return static function () use ($probability): bool {
                                return (mt_rand() / mt_getrandmax()) < $probability;
                            };
                        };

                        return yield from Filter::of()($callback($probability))($iterator);
                    };
            };
    }
}
