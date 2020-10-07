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
final class FoldRight1 extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T|null, T, TKey, Iterator<TKey, T>):(T|null)): Closure(Iterator<TKey, T>): Generator<int|TKey, T|null>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, T|null>
             */
            static function (callable $callback): Closure {
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int|TKey, T|null> $pipe */
                $pipe = Pipe::of()(
                    Reverse::of(),
                    ScanRight1::of()($callback),
                    Head::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
