<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\CachingIteratorAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
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
        /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $takeWhile */
        $takeWhile = (new TakeWhile())()(
            /**
             * @param T $value
             * @param TKey $key
             * @param CachingIteratorAggregate<TKey, T> $iterator
             */
            static fn ($value, $key, CachingIteratorAggregate $iterator): bool => $iterator->hasNext()
        );

        // Point free style.
        return $takeWhile;
    }
}
