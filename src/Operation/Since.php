<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Utils\CallbacksArrayReducer;
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\CachingIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Since extends AbstractOperation
{
    /**
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=):bool ...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=):bool ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $iteratorAggregate = new CachingIteratorAggregate((new IterableIteratorAggregate($iterable))->getIterator());

                    $every = (new Every())()(
                        /**
                         * @param T $value
                         * @param TKey $key
                         * @param iterable<TKey, T> $iterable
                         */
                        static fn (int $index, $value, $key, iterable $iterable): bool => !CallbacksArrayReducer::or()($callbacks)($value, $key, $iterable)
                    )($iteratorAggregate);

                    if (false === $every->current()) {
                        yield from (new Limit())()(-1)($every->key())($iteratorAggregate);
                    }
                };
    }
}
