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
use loophp\iterators\IterableIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Flatten extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(Iterator<TKey, T>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<mixed, mixed>
             */
            static fn (int $depth): Closure =>
                /**
                 * @param Iterator<TKey, T> $iterator
                 */
                static function (Iterator $iterator) use ($depth): Generator {
                    foreach ($iterator as $key => $value) {
                        if (false === is_iterable($value)) {
                            yield $key => $value;

                            continue;
                        }

                        yield from (1 !== $depth)
                            ? (new Flatten())()($depth - 1)(new IterableIterator($value))
                            : $value;
                    }
                };
    }
}
