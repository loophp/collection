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
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\UnpackIterableAggregate;
use Traversable;

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Unpack extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<mixed, mixed>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<array-key, array{0: TKey, 1: T}>): Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Map::of()(static fn (iterable $iterable): Iterator => (new IterableIteratorAggregate($iterable))->getIterator()),
            Map::of()(Chunk::of()(2)),
            Flatten::of()(1),
            static fn (Iterator $iterator): Traversable => (new UnpackIterableAggregate($iterator))->getIterator()
        );

        // Point free style.
        return $pipe;
    }
}
