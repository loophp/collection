<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Tails extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, array<TKey, T>, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<int, array<TKey, T>, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var Iterator<int, array{0: TKey, 1: T}>  */
                $iterator = Pack::of()($iterator);
                $data = iterator_to_array($iterator);

                while ([] !== $data) {
                    /** @psalm-var Iterator<TKey, T> $unpack */
                    $unpack = Unpack::of()(new ArrayIterator($data));

                    yield iterator_to_array($unpack);

                    array_shift($data);
                }

                return yield [];
            };
    }
}
