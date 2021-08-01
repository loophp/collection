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
final class Duplicate extends AbstractOperation
{
    /**
     * @pure
     *
     * @template U
     *
     * @return Closure(callable(U): Closure(U): bool): Closure(callable(T, TKey): U): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(U): (Closure(U): bool) $comparatorCallback
             *
             * @return Closure(callable(T, TKey): U): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $comparatorCallback): Closure =>
                /**
                 * @param callable(T, TKey): U $accessorCallback
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
                 */
                static fn (callable $accessorCallback): Closure =>
                    /**
                     * @param Iterator<TKey, T> $iterator
                     *
                     * @return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($comparatorCallback, $accessorCallback): Generator {
                        // Todo: Find a way to rewrite this using other operations, without side effect.
                        $stack = [];

                        foreach ($iterator as $key => $value) {
                            $comparator = $comparatorCallback($accessorCallback($value, $key));

                            foreach ($stack as $item) {
                                if (true === $comparator($accessorCallback($item[1], $item[0]))) {
                                    yield $key => $value;

                                    continue 2;
                                }
                            }

                            $stack[] = [$key, $value];
                        }
                    };
    }
}
