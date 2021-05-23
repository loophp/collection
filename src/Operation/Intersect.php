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

use function in_array;

/**
 * @template TKey of array-key
 * @template T
 */
final class Intersect extends AbstractOperation
{
    /**
     * @return Closure(T...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$values
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (...$values): Closure {
                $filterCallbackFactory = static fn (array $values): Closure =>
                    /**
                     * @param T $value
                     */
                    static fn ($value): bool => in_array($value, $values, true);

                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()($filterCallbackFactory($values));

                // Point free style.
                return $filter;
            };
    }
}
