<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Equals extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Closure(iterable<TKey, T>): Generator<int|TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $other
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, bool>
             */
            static function (iterable $other): Closure {
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int|TKey, bool>
                 */
                return static function (iterable $iterable) use ($other): Generator {
                    $otherAggregate = new IterableIteratorAggregate($other);
                    $iteratorAggregate = new IterableIteratorAggregate($iterable);

                    $iterator = $iteratorAggregate->getIterator();
                    $other = $otherAggregate->getIterator();

                    while ($other->valid() && $iterator->valid()) {
                        $iterator->next();
                        $other->next();
                    }

                    if ($other->valid() !== $iterator->valid()) {
                        return yield false;
                    }

                    $containsCallback =
                        /**
                         * @param T $current
                         */
                        static fn (int $index, $current): bool => (new Contains())()($current)($otherAggregate)->current();

                    yield from (new Every())()($containsCallback)($iteratorAggregate);
                };
            };
    }
}
