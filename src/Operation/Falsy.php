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
final class Falsy extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        $matchCallback =
            /**
             * @param T $value
             */
            static fn ($value): bool => (bool) $value;

        $mapCallback =
            /**
             * @param T $value
             */
            static fn ($value): bool => !(bool) $value;

        /** @var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
        $pipe = Pipe::of()(
            MatchOne::of()(static fn (): bool => true)($matchCallback),
            Map::of()($mapCallback),
        );

        // Point free style.
        return $pipe;
    }
}
