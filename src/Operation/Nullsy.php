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

use function in_array;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Nullsy extends AbstractOperation
{
    /**
     * @var array{0: null, 1: array<mixed>, 2: int, 3: bool, 4: string}
     */
    public const VALUES = [null, [], 0, false, ''];

    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        $matchWhenNot = static fn (): bool => false;
        $matcher =
            /**
             * @param T $value
             */
            static fn ($value): bool => in_array($value, self::VALUES, true);

        /** @var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
        $pipe = Pipe::of()(
            MatchOne::of()($matchWhenNot)($matcher),
            Map::of()(
                /**
                 * @param T $value
                 */
                static fn ($value): bool => !$value
            ),
        );

        // Point free style.
        return $pipe;
    }
}
