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
     * @psalm-return Closure(float): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (float $probability): Closure {
                $callback = static function (float $probability): Closure {
                    return static function () use ($probability): bool {
                        return (mt_rand() / mt_getrandmax()) < $probability;
                    };
                };

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()($callback($probability));

                // Point free style.
                return $filter;
            };
    }
}
