<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 */
final class Same extends AbstractOperation
{
    /**
     * @return Closure(iterable<mixed, mixed>): Closure(callable(mixed, mixed): Closure(mixed, mixed): bool): Closure(iterable<mixed, mixed>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<mixed, mixed> $other
             *
             * @return Closure(callable(mixed, mixed): Closure(mixed, mixed): bool): Closure(iterable<mixed, mixed>): Generator<int, bool>
             */
            static fn (iterable $other): Closure =>
                /**
                 * @param callable(mixed, mixed): (Closure(mixed, mixed): bool) $comparatorCallback
                 *
                 * @return Closure(iterable<mixed, mixed>): Generator<int, bool>
                 */
                static fn (callable $comparatorCallback): Closure =>
                    /**
                     * @param iterable<mixed, mixed> $iterable
                     *
                     * @return Generator<int, bool>
                     */
                    static function (iterable $iterable) use ($other, $comparatorCallback): Generator {
                        $otherAggregate = new IterableIteratorAggregate($other);
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
