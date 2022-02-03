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
final class Same extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Closure(callable(T, TKey): Closure(T, TKey): bool): Closure(iterable<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<TKey, T> $other
             *
             * @return Closure(callable(T, TKey): Closure(T, TKey): bool): Closure(iterable<TKey, T>): Generator<int, bool>
             */
            static fn (iterable $other): Closure =>
                /**
                 * @param callable(T, TKey): (Closure(T, TKey): bool) $comparatorCallback
                 *
                 * @return Closure(iterable<TKey, T>): Generator<int, bool>
                 */
                static fn (callable $comparatorCallback): Closure =>
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator<int, bool>
                     */
                    static function (iterable $iterable) use ($other, $comparatorCallback): Generator {
                        $otherAggregate = (new IterableIteratorAggregate($other));
                        $iteratorAggregate = new IterableIteratorAggregate($iterable);

                        $iterator = $iteratorAggregate->getIterator();
                        $other = $otherAggregate->getIterator();

                        while ($iterator->valid() && $other->valid()) {
                            if (!$comparatorCallback($iterator->current(), $iterator->key())($other->current(), $other->key())) {
                                return yield false;
                            }

                            $iterator->next();
                            $other->next();
                        }

                        yield $iterator->valid() === $other->valid();
                    };
    }
}
