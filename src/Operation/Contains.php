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
final class Contains extends AbstractOperation
{
    /**
     * @return Closure(T ...$values): Closure(iterable<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$values
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, bool>
             */
            static fn (...$values): Closure => (new MatchOne())()(static fn (): bool => true)(
                /**
                 * @param T $value
                 */
                static fn ($value): bool => in_array($value, $values, true)
            );
    }
}
