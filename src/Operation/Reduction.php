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
final class Reduction extends AbstractOperation
{
    /**
     * @template V
     * @template W
     *
     * @return Closure(callable(mixed=, mixed=, mixed=, iterable<mixed, mixed>=): mixed): Closure(mixed): Closure(iterable<TKey, T>): Generator<TKey, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((V|W)=, T=, TKey=, iterable<TKey, T>=): W $callback
             *
             * @return Closure(V): Closure(iterable<TKey, T>): Generator<TKey, W>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @param V $initial
                 *
                 * @return Closure(iterable<TKey, T>): Generator<TKey, W>
                 */
                static fn ($initial): Closure =>
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator<TKey, W>
                     */
                    static function (iterable $iterable) use ($callback, $initial): Generator {
                        foreach ($iterable as $key => $value) {
                            /** @var W $initial */
                            $initial = $callback($initial, $value, $key, $iterable);

                            yield $key => $initial;
                        }
                    };
    }
}
