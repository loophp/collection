<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 */
final class Equals extends AbstractOperation
{
    /**
     * @return Closure(iterable<mixed, mixed>): Closure(iterable<mixed, mixed>): Generator<int, bool, mixed, false|mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<mixed, mixed> $other
             *
             * @return Closure(iterable<mixed, mixed>): Generator<int, bool, mixed, false|mixed>
             */
            static fn (iterable $other): Closure =>
                /**
                 * @param iterable<mixed, mixed> $iterable
                 *
                 * @return Generator<int, bool, mixed, false|mixed>
                 */
                static function (iterable $iterable) use ($other): Generator {
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

                    $containsCallback = static fn (int $index, mixed $current): bool => (new Contains())()($current)($otherAggregate)->current();

                    yield from (new Every())()($containsCallback)($iteratorAggregate);
                };
    }
}
