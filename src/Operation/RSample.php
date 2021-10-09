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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class RSample implements Operation
{
    /**
     * @pure
     *
     * @return Closure(float): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (float $probability): Closure {
                $callback = static fn (): bool => (mt_rand() / mt_getrandmax()) < $probability;

                $filter = (new Filter())()($callback);

                // Point free style.
                return $filter;
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
