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
use IteratorAggregate;
use loophp\iterators\ClosureIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Span extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(IteratorAggregate<TKey, T>): Generator<int, IteratorAggregate<TKey, T>>
     */
    public function __invoke(): Closure
    {
        /**
         * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$callbacks
         *
         * @return Closure(IteratorAggregate<TKey, T>): Generator<int, IteratorAggregate<TKey, T>>
         */
        return static fn (callable ...$callbacks): Closure =>
            /**
             * @param IteratorAggregate<TKey, T> $iteratorAggregate
             *
             * @return Generator<int, IteratorAggregate<TKey, T>>
             */
            static function (IteratorAggregate $iteratorAggregate) use ($callbacks): Generator {
                yield new ClosureIteratorAggregate((new TakeWhile())()(...$callbacks), [$iteratorAggregate->getIterator()]);

                yield new ClosureIteratorAggregate((new DropWhile())()(...$callbacks), [$iteratorAggregate->getIterator()]);
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
