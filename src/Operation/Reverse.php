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
final class Reverse extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T, mixed, void>
     */
    public function __invoke(): Closure
    {
        $callback =
            /**
             * @param list<T|TKey> $carry
             * @param array{0: TKey, 1: T} $value
             *
             * @return list<array{0: TKey, 1: T}>
             */
            static fn (array $carry, array $value): array => [...$value, ...$carry];

        /** @var Closure(Iterator<TKey, T>): Generator<TKey, T, mixed, void> $pipe */
        $pipe = Pipe::of()(
            (new Pack())(),
            Reduce::of()($callback)([]),
            (new Unpack())(),
        );

        // Point free style.
        return $pipe;
    }
}
