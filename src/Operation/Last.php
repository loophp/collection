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
final class Last extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<TKey, T>
             */
            static function (iterable $iterable): Generator {
                $isEmpty = true;

                $key = $current = null;

                foreach ($iterable as $key => $current) {
                    $isEmpty = false;
                }

                if (!$isEmpty) {
                    yield $key => $current;
                }
            };
    }
}
