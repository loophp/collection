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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class ScanRight1 extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable(T|V, T, TKey, iterable<TKey, T>): V): Closure(iterable<TKey, T>): Generator<int|TKey, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|V, T, TKey, iterable<TKey, T>): V $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, T|V>
             */
            static function (callable $callback): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<int|TKey, T|V> $pipe */
                $pipe = (new Pipe())()(
                    (new Reverse())(),
                    (new ScanLeft1())()($callback),
                    (new Reverse())()
                );

                // Point free style.
                return $pipe;
            };
    }
}
