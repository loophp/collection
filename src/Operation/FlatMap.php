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
final class FlatMap
{
    /**
     * @pure
     *
     * @template IKey
     * @template IValue
     *
     * @return Closure(callable(T=, TKey=, Iterator<TKey, T>=): iterable<IKey, IValue>): Closure(Iterator<TKey, T>): Generator<IKey, IValue>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, Iterator<TKey, T>=): iterable<IKey, IValue> $callback
             */
            static function (callable $callback): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<IKey, IValue> $flatMap */
                $flatMap = (new Pipe())()(
                    (new Map())()($callback),
                    (new Flatten())()(1)
                );

                // Point free style
                return $flatMap;
            };
    }
}
