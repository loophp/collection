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
final class Wrap extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, array<array-key, T>>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, array<array-key, T>> $pipe */
        $pipe = (new Pipe())()(
            (new Map())()(
                /**
                 * @param T $value
                 * @param array-key $key
                 *
                 * @return array<array-key, T>
                 */
                static fn (mixed $value, int|string $key): array => [$key => $value]
            ),
            (new Normalize())()
        );

        // Point free style.
        return $pipe;
    }
}
