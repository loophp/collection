<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\MultipleIterableAggregate;
use MultipleIterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Combine extends AbstractOperation
{
    /**
     * @template U
     *
     * @return Closure(array<U>): Closure(iterable<TKey, T>): Generator<null|U, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<U> $keys
             *
             * @return Closure(iterable<TKey, T>): Generator<null|U, null|T>
             */
            static function (array $keys): Closure {
                $buildMultipleIterable =
                    /**
                     * @param iterable<TKey, T> $iterable
                     *
                     * @return Generator
                     */
                    static fn (iterable $iterable): Generator => yield from new MultipleIterableAggregate([$keys, $iterable], MultipleIterator::MIT_NEED_ANY);

                /** @var Closure(iterable<TKey, T>): Generator<null|U, null|T> $pipe */
                $pipe = (new Pipe())()(
                    $buildMultipleIterable,
                    (new Flatten())()(1),
                    (new Pair())(),
                );

                // Point free style.
                return $pipe;
            };
    }
}
