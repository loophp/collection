<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use EmptyIterator;
use Generator;
use Iterator;

use function count;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Chunk extends AbstractOperation
{
    /**
     * @psalm-return Closure(int...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
             */
            static fn (int ...$sizes): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<int, list<T>>
                 */
                static function (Iterator $iterator) use ($sizes): Generator {
                    /** @psalm-var Iterator<int, int> $sizesIterator */
                    $sizesIterator = Cycle::of()(new ArrayIterator($sizes));
                    $sizesIterator->rewind();

                    $values = [];

                    foreach ($iterator as $value) {
                        $size = $sizesIterator->current();

                        if (0 >= $size) {
                            return new EmptyIterator();
                        }

                        if (count($values) !== $size) {
                            $values[] = $value;

                            continue;
                        }

                        $sizesIterator->next();

                        yield $values;

                        $values = [$value];
                    }

                    return yield $values;
                };
    }
}
