<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Reverse extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        $callback =
            /**
             * @param T $value
             * @param TKey $key
             * @param list<array{0: TKey, 1: T}> $carry
             *
             * @return list<array{0: TKey, 1: T}>
             */
            static fn (array $carry, mixed $value, mixed $key): array => [[$key, $value], ...$carry];

        /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = (new Pipe())()(
            (new Reduce())()($callback)([]),
            (new Unwrap())(),
            (new Unpack())()
        );

        // Point free style.
        return $pipe;
    }
}
