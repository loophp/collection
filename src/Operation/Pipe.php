<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Pipe extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(Iterator<TKey, T>): Iterator<TKey, T> ...): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(Iterator<TKey, T>): Iterator<TKey, T> ...$operations
             *
             * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (callable ...$operations): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Iterator<TKey, T>
                 */
                static fn (Iterator $iterator): Iterator => array_reduce(
                    $operations,
                    /**
                     * TODO: Should we return a new ClosureIterator here ?
                     * Something like: "new ClosureIterator($callable, $iterator)".
                     *
                     * @param Iterator<TKey, T> $iterator
                     * @param callable(Iterator<TKey, T>): Iterator<TKey, T> $callable
                     *
                     * @return Iterator<TKey, T>
                     */
                    static fn (Iterator $iterator, callable $callable): Iterator => $callable($iterator),
                    $iterator
                );
    }
}
