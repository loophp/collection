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
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Unwindow extends AbstractOperation
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

                /** @var T $iterValue */
                foreach ($iterable as $iterValue) {
                    $value = $iterValue;
                }

                return $value;
            }
        );

        // Point free style.
        return $unwindow;
    }
}
