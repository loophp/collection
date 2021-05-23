<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use EmptyIterator;
use Generator;
use Iterator;

/**
 * @template TKey of array-key
 * @template T
 */
final class Head extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>):Generator<TKey, T, mixed, EmptyIterator|mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T, mixed, EmptyIterator|void>
             */
            static function (Iterator $iterator): Generator {
                $isEmpty = true;

                foreach ($iterator as $key => $current) {
                    $isEmpty = false;

                    break;
                }

                if (true === $isEmpty) {
                    return new EmptyIterator();
                }

                /**
                 * @var TKey $key
                 * @var T $current
                 */
                return yield $key => $current;
            };
    }
}
