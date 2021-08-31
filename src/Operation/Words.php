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
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Words implements Operation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param list<string> $value
             */
            static fn (array $value): string => implode('', $value);

        $pipe = (new Pipe())(
            (new Explode())("\t", "\n", ' '),
            (new Map())($mapCallback),
            (new Compact())()
        );
    }
}
