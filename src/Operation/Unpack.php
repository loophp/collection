<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use IteratorAggregate;
use loophp\iterators\IterableIteratorAggregate;
use loophp\iterators\UnpackIterableAggregate;

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
     * @return Closure(iterable<mixed, mixed>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(iterable<array-key, array{0: TKey, 1: T}>): Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Map::of()(static fn (iterable $iterable): iterable => new IterableIteratorAggregate($iterable)),
            Map::of()(Chunk::of()(2)),
            Flatten::of()(1),
            static fn (iterable $iterable): IteratorAggregate => new UnpackIterableAggregate($iterable)
        );

        // Point free style.
        return $pipe;
    }
}
