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

use function array_slice;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Window extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<TKey, list<T>>
             */
            static function (int $size): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<TKey, list<T>> $reduction */
                $reduction = Reduction::of()(
                    /**
                     * @param list<T> $stack
                     * @param T $current
                     *
                     * @return list<T>
                     */
                    static fn (array $stack, $current): array => array_slice([...$stack, $current], ++$size * -1)
                )([]);

                // Point free style.
                return $reduction;
            };
    }
}
