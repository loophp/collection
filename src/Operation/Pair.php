<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Pair extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<T, T|null>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, T>): Generator<T|TKey, T> $pipe */
        $pipe = Pipe::of()(
            Chunk::of()(2),
            Map::of()(
                static fn (array $values): array => array_values($values)
            ),
            Associate::of()(
                static fn ($accumulator, $key, array $value): mixed => current($value)
            )(
                static fn ($accumulator, $key, array $value): mixed => end($value)
            )
        );

        // Point free style.
        return $pipe;
    }
}
