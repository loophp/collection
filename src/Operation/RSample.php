<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class RSample extends AbstractOperation
{
    /**
     * @return Closure(float): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static function (float $probability): Closure {
                $filter = (new Filter())()(
                    static fn (): bool => (mt_rand() / mt_getrandmax()) < $probability
                );

                // Point free style.
                return $filter;
            };
    }
}
