<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

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
     * @return Closure(iterable<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<TKey, T>): Generator<int, bool> $every */
        $every = (new Every())()(
            /**
             * @param T $value
             */
            static fn (int $index, $value): bool => in_array((bool) $value, self::VALUES, true)
        );

        // Point free style.
        return $every;
    }
}
