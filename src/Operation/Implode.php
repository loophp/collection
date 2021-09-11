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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Implode extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(string): Closure(Iterator<TKey, T>): Generator<TKey, string>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<TKey, string>
             */
            static function (string $glue): Closure {
                $reducer =
                    /**
                     * @param string|T $item
                     */
                    static fn (string $carry, $item): string => $carry .= $item;

                /** @var Closure(Iterator<TKey, T>): Generator<TKey, string> $pipe */
                $pipe = Pipe::of()(
                    Intersperse::of()($glue)(1)(0),
                    Drop::of()(1),
                    Reduce::of()($reducer)('')
                );

                // Point free style.
                return $pipe;
            };
    }
}
