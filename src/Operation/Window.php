<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Window extends AbstractOperation implements Operation
{
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
                    $loop = (new Loop())();

                    /** @psalm-var Iterator<int, int> $lengths */
                    $lengths = (new Run())()($loop)(new ArrayIterator($lengths));

                    for ($i = 0; iterator_count($iterator) > $i; ++$i) {
                        $slice = (new Slice())()($i)($lengths->current());

                        yield iterator_to_array((new Run())()($slice)($iterator));

                        $lengths->next();
                    }
                };
        };
    }
}
