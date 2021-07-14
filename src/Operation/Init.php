<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use CachingIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Init extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterable
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterable): Generator {
                $cacheIterator = new CachingIterator($iterable, CachingIterator::FULL_CACHE);

                foreach ($cacheIterator as $key => $current) {
                    if (false === $iterable->valid()) {
                        break;
                    }

                    yield $key => $current;
                }
            };
    }
}
