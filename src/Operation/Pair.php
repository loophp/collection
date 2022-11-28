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
final class Pair extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<T, T|null>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<T, T|null> $pipe */
        $pipe = (new Pipe())()(
            (new Normalize())(),
            (new Chunk())()(2),
            (new Associate())()(
                /**
                 * @param TKey $key
                 * @param array{0: TKey, 1: T} $value
                 *
                 * @return TKey|null
                 */
                static fn (mixed $key, array $value): mixed => $value[0] ?? null
            )(
                /**
                 * @param array{0: TKey, 1: T} $value
                 *
                 * @return T|null
                 */
                static fn (array $value): mixed => $value[1] ?? null
            )
        );

        // Point free style.
        return $pipe;
    }
}
