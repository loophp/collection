<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Iterator\IterableIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Flatten extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, T>
             */
            static fn (int $depth): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 */
                static function (Iterator $iterator) use ($depth): Generator {
                    foreach ($iterator as $key => $value) {
                        if (false === is_iterable($value)) {
                            yield $key => $value;

                            continue;
                        }

                        if (1 !== $depth) {
                            /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $flatten */
                            $flatten = Flatten::of()($depth - 1);

                            $value = $flatten(new IterableIterator($value));
                        }

                        yield from $value;
                    }
                };
    }
}
