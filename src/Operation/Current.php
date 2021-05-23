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
 * @template TKey of array-key
 * @template T
 */
final class Current extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param int $index
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $index): Closure {
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $limit */
                $limit = Limit::of()(1)($index);

                // Point free style.
                return $limit;
            };
    }
}
