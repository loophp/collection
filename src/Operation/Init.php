<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use CachingIterator;
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
final class Init extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<TKey, T>
     * @psalm-suppress InvalidArgument
     */
    public function __invoke(): Closure
    {
        $buildCachingIterator =
            /**
             * @param iterable<TKey, T> $iterable
             *
             * @return CachingIterator<TKey, T>
             */
            static fn (iterable $iterator): CachingIterator => new CachingIterator((new IterableIteratorAggregate($iterator))->getIterator(), CachingIterator::FULL_CACHE);

        /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $takeWhile */
        $takeWhile = (new Pipe())()(
            $buildCachingIterator,
            (new TakeWhile())()(
                /**
                 * @param T $value
                 * @param TKey $key
                 * @param CachingIterator<TKey, T> $iterator
                 */
                static fn ($value, $key, CachingIterator $iterator): bool => $iterator->hasNext()
            )
        );

        // Point free style.
        return $takeWhile;
    }
}
