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
use Throwable;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Squash extends AbstractOperation
{
    /**
     * @psalm-return Closure(bool): Closure(Iterator<TKey, T>): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static function (bool $throwOnException): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($throwOnException): Closure {
                        // As keys can be of any type in this library.We cannot use
                        // iterator_to_array() because it expect keys to be int|string.
                        try {
                            foreach ($iterator as $key => $value) {
                            }
                        } catch (Throwable $e) {
                            if (true === $throwOnException) {
                                throw $e;
                            }
                        }

                        return
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<TKey, T>
                             */
                            static function (Iterator $iterator) use ($throwOnException): Generator {
                                try {
                                    foreach ($iterator as $key => $value) {
                                        yield $key => $value;
                                    }
                                } catch (Throwable $e) {
                                    if (true === $throwOnException) {
                                        throw $e;
                                    }
                                }
                            };
                    };
            };
    }
}
