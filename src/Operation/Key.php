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
final class Key extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(Iterator<TKey, <|int, TKey|T>): Generator>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, <|int, TKey|T>): Generator>
             */
            static function (int $index): Closure {
                /** @var Closure(Iterator<TKey, <|int, TKey|T>): Generator> $pipe */
                $pipe = Pipe::of()(
                    Limit::of()(1)($index),
                    Flip::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
