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
 * @todo Remove the Wrap and Unwrap operations
 * @todo They are only needed when: Collection::empty()->reverse()
 * @todo Most probably that the FoldLeft operation needs an update.
 *
 * @template TKey
 * @template T
 */
final class Reverse extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T, mixed, void>
     */
    public function __invoke(): Closure
    {
        $callback =
            /**
             * @param list<array{0: TKey, 1: T}> $carry
             * @param list<array{0: TKey, 1: T}> $value
             *
             * @return list<array{0: TKey, 1: T}>
             */
            static fn (array $carry, array $value): array => [...$value, ...$carry];

        /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Pack::of(),
            Wrap::of(),
            FoldLeft::of()($callback)([]),
            Flatten::of()(1),
            Unpack::of(),
        );

        // Point free style.
        return $pipe;
    }
}
