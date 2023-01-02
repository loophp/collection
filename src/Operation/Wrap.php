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
     * @return Closure(iterable<TKey, T>): Generator<int, array<TKey, T>>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, array<TKey, T>> $pipe */
        $pipe = (new Pipe())()(
            (new Map())()(
                /**
                 * @param T $value
                 * @param TKey $key
                 *
                 * @return array<TKey, T>
                 */
                static fn (mixed $value, mixed $key): array => [$key => $value]
            ),
            (new Normalize())()
        );

        // Point free style.
        return $pipe;
    }
}
