<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Zip extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable ...$iterables): Closure {
            return
                /**
                 * @psalm-param \Iterator<TKey, T> $iterator
                 * @psalm-param list<iterable<TKey, T>> $iterables
                 *
                 * @psalm-return \Generator<int, list<T>>
                 */
                static function (Iterator $iterator) use ($iterables): Generator {
                    $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);
                    $mit->attachIterator($iterator);

                    foreach ($iterables as $iterableIterator) {
                        $mit->attachIterator(new IterableIterator($iterableIterator));
                    }

                    foreach ($mit as $values) {
                        yield $values;
                    }
                };
        };
    }
}
