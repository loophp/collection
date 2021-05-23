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
 * @template TKey of array-key
 * @template T
 */
final class Pack extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param mixed $value
             * @psalm-param T $value
             *
             * @param mixed $key
             * @psalm-param TKey $key
             *
             * @psalm-return array{0: TKey, 1: T}
             */
            static fn ($value, $key): array => [$key, $value];

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<int, array{0: TKey, 1: T}> $pipe */
        $pipe = Pipe::of()(
            Map::of()($mapCallback),
            Normalize::of()
        );

        // Point free style.
        return $pipe;
    }
}
