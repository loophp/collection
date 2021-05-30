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
 * @template TKey
 * @template T
 */
final class DiffKeys extends AbstractOperation
{
    /**
     * @return Closure(TKey...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param TKey ...$values
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (...$values): Closure {
                $filterCallbackFactory = static fn (array $values): Closure =>
                    /**
                     * @param T $value
                     * @param TKey $key
                     */
                    static fn ($value, $key): bool => false === in_array($key, $values, true);

                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()($filterCallbackFactory($values));

                // Point free style.
                return $filter;
            };
    }
}
