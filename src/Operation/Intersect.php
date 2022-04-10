<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use function in_array;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Intersect extends AbstractOperation
{
    /**
     * @return Closure(T...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$values
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (...$values): Closure => (new Filter())()(
                /**
                 * @param T $value
                 */
                static fn ($value): bool => in_array($value, $values, true)
            );
    }
}
