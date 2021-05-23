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
final class Words extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @psalm-param list<string> $value
             */
            static fn (array $value): string => implode('', $value);

        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, string> $pipe */
        $pipe = Pipe::of()(
            Explode::of()("\t", "\n", ' '),
            Map::of()($mapCallback),
            Compact::of()()
        );

        // Point free style.
        return $pipe;
    }
}
