<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use EmptyIterator;
use Iterator;

/**
 * @template TKey of array-key
 * @template T
 */
final class Last extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Iterator<TKey, T>
             */
            static function (Iterator $iterator): Iterator {
                $isEmpty = true;

                foreach ($iterator as $key => $current) {
                    $isEmpty = false;
                }

                if (true === $isEmpty) {
                    return new EmptyIterator();
                }

                /**
                 * @psalm-var TKey $key
                 * @psalm-var T $current
                 */
                return yield $key => $current;
            };
    }
}
