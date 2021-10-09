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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class FlatMap implements Operation
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
                $flatMap = Pipe::of()(
                    Map::of()($callback),
                    Flatten::of()(1)
                );

                // Point free style
                return $flatMap;
            };
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}
