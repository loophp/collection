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

use const PHP_EOL;

/**
 * @template TKey of array-key
 * @template T
 */
final class Lines extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, (T|string)>): Generator<int, string>
     */
    public function __invoke(): Closure
    {
        $mapCallback =
            /**
             * @param T $value
             */
            static fn (array $value): string => implode('', $value);

        /** @var Closure(Iterator<TKey, (T|string)>): Generator<int, string> $pipe */
        $pipe = Pipe::of()(
            Explode::of()(PHP_EOL, "\n", "\r\n"),
            Map::of()($mapCallback)
        );

        // Point free style.
        return $pipe;
    }
}
