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
 */
final class Flip extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<T, TKey>
     */
    public function __invoke(): Closure
    {
        $callbackForKeys =
            /**
             * @param TKey $key
             * @param T $value
             *
             * @return T
             */
            static fn ($key, $value) => $value;

        $callbackForValues =
            /**
             * @param T $value
             * @param TKey $key
             *
             * @return TKey
             */
            static fn ($value, $key) => $key;

        /** @var Closure(Iterator<TKey, T>): Generator<T, TKey> $associate */
        $associate = Associate::of()($callbackForKeys)($callbackForValues);

        // Point free style.
        return $associate;
    }
}
