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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Combine extends AbstractOperation
{
    /**
     * @template U
     *
     * @return Closure(U...): Closure(iterable<TKey, T>): Generator<null|U, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param U ...$keys
             *
             * @return Closure(iterable<TKey, T>): Generator<null|U, null|T>
             */
            static function (...$keys): Closure {
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
