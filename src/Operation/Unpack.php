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
use loophp\collection\Iterator\IterableIterator;

/**
 * @template TKey of array-key
 * @template T
 */
final class Unpack extends AbstractOperation
{
    /**
     * @return Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T>
     */
    public function __invoke(): Closure
    {
        $toIterableIterator = static fn (iterable $value): Iterator => new IterableIterator($value);

        $callbackForKeys =
            /**
             * @param T $initial
             * @param array{0: TKey, 1: T} $value
             *
             * @return TKey
             */
            static fn ($initial, int $key, array $value) => $value[0];

        $callbackForValues =
            /**
             * @param T $initial
             * @param array{0: TKey, 1: T} $value
             *
             * @return T
             */
            static fn ($initial, int $key, array $value) => $value[1];

        /** @var Closure(Iterator<int, array{0: TKey, 1: T}>): Generator<T, T> $pipe */
        $pipe = Pipe::of()(
            Map::of()($toIterableIterator, Chunk::of()(2)),
            Unwrap::of(),
            Associate::of()($callbackForKeys)($callbackForValues)
        );

        // Point free style.
        return $pipe;
    }
}
