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
 */
final class Falsy extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return (new Every())()(
            /**
             * @param T $value
             */
            static fn (int $index, $value): bool => !(bool) $value
        );
    }
}
