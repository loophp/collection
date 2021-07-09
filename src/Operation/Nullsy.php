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
 */
final class Nullsy extends AbstractOperation
{
    /**
     * @param list<null, array, int, bool, string>
     */
    public const VALUES = [null, [], 0, false, ''];

    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
        $pipe = Pipe::of()(
            MatchOne::of()(static fn (): bool => false)(static fn ($value): bool => in_array($value, self::VALUES, true)),
            Map::of()(static fn ($value): bool => !$value),
        );

        // Point free style.
        return $pipe;
    }
}
