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
        return static function (Iterator $iterator, ArrayIterator $length): Generator {
            /** @psalm-var \Iterator<int, int> $length */
            $length = (new Run())()($length, new Loop());

            for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                /** @psalm-var \Iterator<TKey, T> $windowIterator */
                $windowIterator = (new Run())()($iterator, new Slice($i, $length->current()));

                yield iterator_to_array($windowIterator);

                $length->next();
            }
        };
    }
}
