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
 */
final class Window extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(int...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return static function (int ...$lengths): Closure {
            return
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 * @psalm-param ArrayIterator<int, int> $length
                 *
                 * @psalm-return Generator<int, list<T>>
                 */
                static function (Iterator $iterator) use ($lengths): Generator {
                    /** @psalm-var \Iterator<int, int> $lengths */
                    $lengths = Loop::of()(new ArrayIterator($lengths));

                    for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                        yield iterator_to_array(
                            Slice::of()($i)($lengths->current())($iterator)
                        );

                        $lengths->next();
                    }
                };
        };
    }
}
