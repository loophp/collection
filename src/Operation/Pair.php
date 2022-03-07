<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
            (new Chunk())()(2),
            (new Map())()(static fn (array $value): array => array_values($value)),
            (new Associate())()(
                /**
                 * @param TKey $key
                 * @param array{0: TKey, 1: T} $value
                 *
                 * @return TKey|null
                 */
                static fn ($key, array $value) => $value[0] ?? null
            )(
                /**
                 * @param array{0: TKey, 1: T} $value
                 *
                 * @return T|null
                 */
                static fn (array $value) => $value[1] ?? null
            )
        );

        // Point free style.
        return $pipe;
    }
}
