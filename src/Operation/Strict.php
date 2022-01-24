<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use IteratorAggregate;
use loophp\iterators\TypedIteratorAggregate;

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
     * @return Closure(null|callable(mixed): string): Closure(Iterator<TKey, T>): IteratorAggregate<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param null|callable(mixed): string $callback
             *
             * @return Closure(Iterator<TKey, T>): IteratorAggregate<TKey, T>
             */
            static fn (?callable $callback = null): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 *
                 * @return IteratorAggregate<TKey, T>
                 */
                static fn (Iterator $iterator): IteratorAggregate => new TypedIteratorAggregate($iterator, $callback);
    }
}
