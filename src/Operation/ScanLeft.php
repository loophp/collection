<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class ScanLeft extends AbstractOperation
{
    /**
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>): (T|null)):Closure (T|null): Closure(Iterator<TKey, T>): Generator<int|TKey, T|null>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @return Closure(T|null): Closure(Iterator<TKey, T>): Generator<int|TKey, T|null>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param T|null $initial
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<int|TKey, T|null>
                 */
                static function ($initial = null) use ($callback): Closure {
                    /** @var Closure(Iterator<TKey, T>): Generator<int|TKey, T|null> $pipe */
                    $pipe = Pipe::of()(
                        Reduction::of()($callback)($initial),
                        Prepend::of()($initial)
                    );

                    return $pipe;
                };
    }
}
