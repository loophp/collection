<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
final class ScanLeft extends AbstractOperation
{
    /**
     * @pure
     *
     * @template V
     * @template W
     *
     * @return Closure(callable(mixed=, T=, TKey=, iterable<TKey, T>=): mixed): Closure(mixed): Closure(iterable<TKey, T>): Generator<int|TKey, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<int|TKey, V|W>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(iterable<TKey, T>): Generator<int|TKey, V|W>
                 */
                static function ($initial) use ($callback): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<int|TKey, V|W> $pipe */
                    $pipe = (new Pipe())()(
                        (new Reduction())()($callback)($initial),
                        (new Prepend())()($initial)
                    );

                    return $pipe;
                };
    }
}
