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
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Associate extends AbstractOperation
{
    /**
     * @pure
     *
     * @template NewTKey
     * @template NewT
     *
     * @return Closure((callable((TKey|NewTKey)=, T=, TKey=, Iterator<TKey, T>=): NewTKey) ...): Closure((callable((T|NewT)=, T=, TKey=, Iterator<TKey, T>=): NewT)...): Closure(Iterator<TKey, T>): Generator<NewTKey, NewT>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable((TKey|NewTKey)=, T=, TKey=, Iterator<TKey, T>=): NewTKey ...$callbackForKeys
             *
             * @return Closure((callable((T|NewT)=, T=, TKey=, Iterator<TKey, T>=): NewT)...): Closure(Iterator<TKey, T>): Generator<NewTKey, NewT>
             */
            static fn (callable ...$callbackForKeys): Closure =>
                /**
                 * @param callable((T|NewT)=, T=, TKey=, Iterator<TKey, T>=): NewT ...$callbackForValues
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<NewTKey, NewT>
                 */
                static fn (callable ...$callbackForValues): Closure =>
                    /**
                     * @param Iterator<TKey, T> $iterator
                     *
                     * @return Generator<NewTKey, NewT>
                     */
                    static function (Iterator $iterator) use ($callbackForKeys, $callbackForValues): Generator {
                        $callbackFactory =
                            /**
                             * @param TKey $key
                             *
                             * @return Closure(T): Closure(T|TKey, callable((T|TKey)=, TKey=, T=, Iterator<TKey, T>=): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                             */
                            static fn ($key): Closure =>
                                /**
                                 * @param T $value
                                 *
                                 * @return Closure(T|TKey, callable((T|TKey)=, TKey=, T=, Iterator<TKey, T>=): (T|TKey), int, Iterator<TKey, T>): (T|TKey)
                                 */
                                static fn ($value): Closure =>
                                    /**
                                     * @param T|TKey $accumulator
                                     * @param callable((T|TKey)=, TKey=, T=, Iterator<TKey, T>=): (T|TKey) $callback
                                     * @param Iterator<TKey, T> $iterator
                                     *
                                     * @return T|TKey
                                     */
                                    static fn ($accumulator, callable $callback, int $callbackId, Iterator $iterator) => $callback($accumulator, $key, $value, $iterator);

                        foreach ($iterator as $key => $value) {
                            $reduceCallback = $callbackFactory($key)($value);

                            /** @var Generator<int, NewTKey> $k */
                            $k = Reduce::of()($reduceCallback)($key)(new ArrayIterator($callbackForKeys));

                            /** @var Generator<int, NewT> $c */
                            $c = Reduce::of()($reduceCallback)($value)(new ArrayIterator($callbackForValues));

                            yield $k->current() => $c->current();
                        }
                    };
    }
}
