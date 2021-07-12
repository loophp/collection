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
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Reduction extends AbstractOperation
{
    /**
     * @pure
     *
     * @template V
     *
     * @return Closure(callable((V|null), T, TKey, Iterator<TKey, T>): (V|null)): Closure (V|null): Closure(Iterator<TKey, T>): Generator<TKey, (V|null)>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((V|null), T, TKey, Iterator<TKey, T>): (V|null) $callback
             *
             * @return Closure(V|null): Closure(Iterator<TKey, T>): Generator<TKey, (V|null)>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V|null $initial
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey, (V|null)>
                 */
                static fn ($initial): Closure =>
                    /**
                     * @param Iterator<TKey, T> $iterator
                     *
                     * @return Generator<TKey, (V|null)>
                     */
                    static function (Iterator $iterator) use ($callback, $initial): Generator {
                        foreach ($iterator as $key => $value) {
                            yield $key => ($initial = $callback($initial, $value, $key, $iterator));
                        }
                    };
    }
}
