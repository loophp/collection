<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function count;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Chunk extends AbstractOperation
{
    /**
     * @return Closure(int...): Closure(iterable<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<int, list<T>>
             */
            static fn (int ...$sizes): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int, list<T>>
                 */
                static function (iterable $iterable) use ($sizes): Generator {
                    /** @var Iterator<int, int> $sizesIterator */
                    $sizesIterator = (new Cycle())()($sizes);

                    $values = [];

                    foreach ($iterable as $value) {
                        $size = $sizesIterator->current();

                        if (0 >= $size) {
                            return;
                        }

                        if (count($values) !== $size) {
                            $values[] = $value;

                            continue;
                        }

                        $sizesIterator->next();

                        yield $values;

                        $values = [$value];
                    }

                    yield $values;
                };
    }
}
