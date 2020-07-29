<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

use function count;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
final class Chunk extends AbstractOperation implements Operation
{
    public function __construct(int ...$size)
    {
        $this->storage['size'] = $size;
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
             * @psalm-param list<int> $sizes
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, array $sizes): Generator {
                $sizesIterator = new IterableIterator(
                    (new Run(new Loop()))($sizes)
                );

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
