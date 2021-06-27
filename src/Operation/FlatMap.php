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
 * @template TKey
 * @template T
 */
final class FlatMap extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey, Iterator<TKey, T>): T): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, Iterator<TKey, T>): T $callback
             */
            static function (callable $callback): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $flatMap */
                $flatMap = Pipe::of()(
                    Map::of()($callback),
                    Unwrap::of(),
                    Normalize::of()
                );

                // Point free style
                return $flatMap;
            };
    }
}
