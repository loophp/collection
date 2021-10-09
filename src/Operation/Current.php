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
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Current implements Operation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $index): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $limit */
                $limit = Limit::of()(1)($index);

                // Point free style.
                return $limit;
            };
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}
