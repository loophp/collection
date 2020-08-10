<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Window extends AbstractGeneratorOperation implements Operation
{
    public function __construct(int ...$length)
    {
        $this->storage['length'] = new ArrayIterator($length);
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param \ArrayIterator<int, int> $length
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, ArrayIterator $length): Generator {
                /** @psalm-var \Iterator<int, int> $length */
                $length = (new Run(new Loop()))($length);

                for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                    /** @psalm-var list<T> $window */
                    yield iterator_to_array((new Run(new Slice($i, $length->current())))($iterator));

                    $length->next();
                }
            };
    }
}
