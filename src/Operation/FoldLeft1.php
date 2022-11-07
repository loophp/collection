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
final class FoldLeft1 extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable((T|V), T, TKey, iterable<TKey, T>): V): Closure(iterable<TKey, T>): Generator<int|TKey, V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((T|V), T, TKey, iterable<TKey, T>): V $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, V>
             */
            static function (callable $callback): Closure {
                /** @var Closure(iterable<TKey, T>):(Generator<int|TKey, V>) $pipe */
                $pipe = (new Pipe())()(
                    (new ScanLeft1())()($callback),
                    (new Last())()
                );

                // Point free style.
                return $pipe;
            };
    }
}
