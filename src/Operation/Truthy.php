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
final class Truthy extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        $matchWhenNot = static fn (): bool => true;
        $matcher =
            /**
             * @param bool $value
             */
            static fn (bool $value): bool => !$value;

        /** @var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
        $pipe = Pipe::of()(
            Map::of()(
                /**
                 * @param T $value
                 */
                static fn ($value): bool => (bool) $value
            ),
            MatchOne::of()($matchWhenNot)($matcher),
            Map::of()($matcher),
        );

        // Point free style.
        return $pipe;
    }
}
