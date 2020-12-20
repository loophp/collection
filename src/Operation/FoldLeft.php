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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class FoldLeft extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable((T | null) , T , TKey , Iterator<TKey, T> ): (T | null)):Closure (T): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @psalm-param null|T $initial
                 *
                 * @param mixed|null $initial
                 */
                static function ($initial = null) use ($callback): Closure {
                    /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = Pipe::of()(
                        ScanLeft::of()($callback)($initial),
                        Last::of()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
