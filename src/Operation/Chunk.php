<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function count;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Chunk extends AbstractGeneratorOperation implements Operation
{
    public function __construct(int ...$size)
    {
        $this->storage['size'] = new ArrayIterator($size);
    }

    /**
     * @psalm-template U
     *
     * @psalm-return \Closure(\Iterator<TKey, T>, list<int>):(\Generator<int, list<T>>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param ArrayIterator<int, int> $sizes
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, ArrayIterator $sizes): Generator {
                $sizesIterator = (new Run(new Loop()))()($sizes);

                $values = [];

                foreach ($iterator as $value) {
                    if (0 >= $sizesIterator->current()) {
                        return yield from [];
                    }

                    if (count($values) !== $sizesIterator->current()) {
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
