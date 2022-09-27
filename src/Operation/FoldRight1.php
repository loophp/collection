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
final class FoldRight1 extends AbstractOperation
{
    /**
     * @return Closure(callable((T|null), T, TKey, iterable<TKey, T>): (T|null)):Closure (iterable<TKey, T>): Generator<int|TKey, T|null>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, iterable<TKey, T>):(T|null) $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, T|null>
             */
            static function (callable $callback): Closure {
                /** @var Closure(iterable<TKey, T>):(Generator<int|TKey, T|null>) $pipe */
                $pipe = (new Pipe())()(
                    (new ScanRight1())()($callback),
                    (new Head())()
                );

                // Point free style.
                return $pipe;
            };
    }
}
