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
use loophp\fpt\FPT;

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
     * @return Closure(...callable(Iterator<TKey, T>):Generator<TKey, T, mixed, mixed>):Closure(Iterator<TKey, T>):Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(Iterator<TKey, T>): Generator<TKey, T> ...$operations
             *
             * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (callable ...$operations): Closure => FPT::partialRight()('array_reduce')(
                $operations,
                /**
                         * @param Iterator<TKey, T> $iterator
                         * @param callable(Iterator<TKey, T>): Iterator<TKey, T> $callable
                         *
                         * @return Iterator<TKey, T>
                         */
                        static fn (Iterator $iterator, callable $callable): Iterator => $callable($iterator)
            );
    }
}
