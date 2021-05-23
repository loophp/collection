<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Associate extends AbstractOperation
{
    /**
     * @return Closure(callable(TKey, TKey, T, Iterator<TKey, T>): (T|TKey) ...): Closure((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(TKey, TKey, T, Iterator<TKey, T>): (T|TKey) ...$callbackForKeys
             *
             * @return Closure((callable(T, TKey, T, Iterator<TKey, T>): (T|TKey))...): Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
             */
            static fn (callable ...$callbackForKeys): Closure =>
                /**
                 * @psalm-param callable(T, TKey, T, Iterator<TKey, T>): (T|TKey) ...$callbackForValues
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey|T, T|TKey>
                 */
                static fn (callable ...$callbackForValues): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @return Generator<T|TKey, T|TKey>
                     */
                    static function (Iterator $iterator) use ($callbackForKeys, $callbackForValues): Generator {
                        $callbackFactory =
                            /**
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @return Closure(T): Closure(T|TKey, callable(T|TKey, TKey, T, Iterator<TKey, T>): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                             */
                            static fn ($key): Closure =>
                                /**
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 *
                                 * @return Closure(T|TKey, callable(T|TKey, TKey, T, Iterator<TKey, T>): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                                 */
                                static fn ($value): Closure =>
                                    /**
                                     * @param mixed $accumulator
                                     * @psalm-param T|TKey $accumulator
                                     * @psalm-param callable(T|TKey, TKey, T, Iterator<TKey, T>): (T|TKey) $callback
                                     * @psalm-param Iterator<TKey, T> $iterator
                                     *
                                     * @return T|TKey
                                     */
                                    static fn ($accumulator, callable $callback, int $callbackId, iterable $iterator) => $callback($accumulator, $key, $value, $iterator);

                        foreach ($iterator as $key => $value) {
                            /** @psalm-var Generator<int, TKey|T> $k */
                            $k = FoldLeft::of()($callbackFactory($key)($value))($key)(new ArrayIterator($callbackForKeys));

                            /** @psalm-var Generator<int, T|TKey> $c */
                            $c = FoldLeft::of()($callbackFactory($key)($value))($value)(new ArrayIterator($callbackForValues));

                            yield $k->current() => $c->current();
                        }
                    };
    }
}
