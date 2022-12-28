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
final class Compare extends AbstractOperation
{
    /**
     * @return Closure(callable(T, T, TKey, iterable<TKey, T>): T): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, T, TKey, iterable<TKey, T>): T $comparator
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey,T>
             */
            static function (callable $comparator): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $foldLeft1 */
                $foldLeft1 = (new FoldLeft1())()($comparator);

                // Point free style.
                return $foldLeft1;
            };
    }
}
