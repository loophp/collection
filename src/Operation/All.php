<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class All extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(bool): Closure(iterable<TKey, T>): iterable<int, T>|iterable<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): iterable<int, T>|iterable<TKey, T>
             */
            static fn (bool $normalize): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return iterable<int, T>|iterable<TKey, T>
                 */
                static fn (iterable $iterable): iterable => $normalize ? (new Normalize())()($iterable) : $iterable;
    }
}
