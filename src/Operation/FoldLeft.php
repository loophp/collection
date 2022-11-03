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
final class FoldLeft extends AbstractOperation
{
    /**
     * @template V
     * @template W
     *
     * @return Closure(callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W): Closure(V): Closure(iterable<TKey, T>): Generator<TKey, V|W>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<TKey, V|W>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, V|W>
                 */
                static function ($initial) use ($callback): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<TKey, V|W> $pipe */
                    $pipe = (new Pipe())()(
                        (new ScanLeft())()($callback)($initial),
                        (new Last())()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
