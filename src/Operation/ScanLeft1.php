<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class ScanLeft1 extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable(mixed, T, TKey, iterable<TKey, T>): mixed): Closure(iterable<TKey, T>): Generator<int|TKey, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|V, T, TKey, iterable<TKey, T>): V $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, T|V>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @return Generator<int|TKey, T|V>
                 */
                static function (iterable $iterable) use ($callback): Generator {
                    $iteratorAggregate = new IterableIteratorAggregate($iterable);

                    $iteratorInitial = $iteratorAggregate->getIterator();

                    if (false === $iteratorInitial->valid()) {
                        return yield from [];
                    }

                    $initial = $iteratorInitial->current();

                    /** @var Closure(iterable<TKey, T>): Generator<int|TKey, T|V> $pipe */
                    $pipe = (new Pipe())()(
                        (new Tail())(),
                        (new Reduction())()($callback)($initial),
                        (new Prepend())()($initial)
                    );

                    yield from $pipe($iteratorAggregate->getIterator());
                };
    }
}
