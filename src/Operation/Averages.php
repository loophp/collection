<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Averages extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, float>
     */
    public function __invoke(): Closure
    {
        return (new Pipe())()(
            (new Normalize())(),
            (new ScanLeft1())()(
                /**
                 * @param float $acc
                 * @param float $value
                 *
                 * @return float
                 */
                static fn ($acc, $value, int $key) => ($acc * $key + $value) / ($key + 1)
            )
        );
    }
}
