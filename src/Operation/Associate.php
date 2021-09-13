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
final class Associate extends AbstractOperation
{
    /**
     * @pure
     *
     * @template NewTKey
     * @template NewT
     *
     * @return Closure(callable(TKey=, T=, Iterator<TKey, T>=): NewTKey): Closure(callable(T=, TKey=, Iterator<TKey, T>=): NewT): Closure(Iterator<TKey, T>): Generator<NewTKey, NewT>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(TKey=, T=, Iterator<TKey, T>=): NewTKey $callbackForKeys
             *
             * @return Closure((callable(T=, TKey=, Iterator<TKey, T>=): NewT)): Closure(Iterator<TKey, T>): Generator<NewTKey, NewT>
             */
            static fn (callable $callbackForKeys): Closure =>
                /**
                 * @param callable(T=, TKey=, Iterator<TKey, T>=): NewT $callbackForValues
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<NewTKey, NewT>
                 */
                static fn (callable $callbackForValues): Closure =>
                    /**
                     * @param Iterator<TKey, T> $iterator
                     *
                     * @return Generator<NewTKey, NewT>
                     */
                    static function (Iterator $iterator) use ($callbackForKeys, $callbackForValues): Generator {
                        foreach ($iterator as $key => $value) {
                            yield $callbackForKeys($key, $value, $iterator) => $callbackForValues($value, $key, $iterator);
                        }
                    };
    }
}
