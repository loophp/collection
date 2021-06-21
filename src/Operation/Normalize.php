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
 * @template TKey
 * @template T
 */
final class Normalize extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, T>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $value) {
                    yield $value;
                }
            };
    }
}
