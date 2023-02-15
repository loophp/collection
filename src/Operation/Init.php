<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\CachingIteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Init extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     *
     * @psalm-suppress InvalidArgument
     */
    public function __invoke(): Closure
    {
        $buildCachingIterator =
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return CachingIteratorAggregate<TKey, T>
             */
            static fn (iterable $iterator): CachingIteratorAggregate => new CachingIteratorAggregate((new IterableIteratorAggregate($iterator))->getIterator());

        /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $takeWhile */
        $takeWhile = (new Pipe())()(
            $buildCachingIterator,
            (new TakeWhile())()(
                /**
                 * @param T $value
                 * @param TKey $key
                 * @param CachingIteratorAggregate<TKey, T> $iterator
                 */
                static fn ($value, $key, CachingIteratorAggregate $iterator): bool => $iterator->hasNext()
            )
        );

        // Point free style.
        return $takeWhile;
    }
}
