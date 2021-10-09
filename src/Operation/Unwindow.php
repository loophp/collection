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
final class Unwindow implements Operation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, list<T>>): Generator<TKey, T|null>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, list<T>>): Generator<TKey, T|null> $unwindow */
        $unwindow = Map::of()(
            /**
             * @param iterable<TKey, list<T>> $iterable
             *
             * @return T|null
             */
            static function (iterable $iterable) {
                $value = null;

                /** @var T $value */
                foreach ($iterable as $value) {
                }

                return $value;
            }
        );

        // Point free style.
        return $unwindow;
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}
