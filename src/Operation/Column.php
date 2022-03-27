<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Column extends AbstractOperation
{
    /**
     * @return Closure(mixed): Closure(iterable<TKey, T>): Generator<int, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $column
             *
             * @return Closure(iterable<TKey, T>): Generator<int, mixed>
             */
            static function ($column): Closure {
                $filterCallbackBuilder =
                    /**
                     * @param T $value
                     * @param TKey $key
                     */
                    static fn ($value, $key): bool => $key === $column;

                /** @var Closure(iterable<TKey, T>): Generator<int, mixed> $pipe */
                $pipe = (new Pipe())()(
                    (new Transpose())(),
                    (new Filter())()($filterCallbackBuilder),
                    (new Head())(),
                    (new Flatten())()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
