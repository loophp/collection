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
final class Group extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterable
             *
             * @return Generator<int, list<T>>
             */
            static function (Iterator $iterable): Generator {
                $last = [];

                foreach ($iterable as $current) {
                    if ([] === $last) {
                        $last = [$current];

                        continue;
                    }

                    if (current($last) === $current) {
                        $last[] = $current;

                        continue;
                    }

                    yield $last;

                    $last = [$current];
                }

                if ([] !== $last) {
                    yield $last;
                }
            };
    }
}
