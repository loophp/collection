<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Iterator\TypedIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Strict extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(null|callable(mixed): string): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param null|callable(mixed): string $callback
             *
             * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (?callable $callback = null): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return Iterator<TKey, T>
                 */
                static fn (Iterator $iterator): Iterator => new TypedIterator($iterator, $callback);
    }
}
