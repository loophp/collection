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
final class Unpair extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(iterable<TKey, T>): Generator<int, (TKey|T), mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<int, (TKey|T), mixed, void>
             */
            static function (iterable $iterable): Generator {
                foreach ($iterable as $key => $value) {
                    yield $key;

                    yield $value;
                }
            };
    }
}
