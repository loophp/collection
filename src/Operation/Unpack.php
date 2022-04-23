<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
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
     * @return Closure(iterable<mixed, mixed>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
           /**
            * @param iterable<array{0: TKey, 1: T}> $iterable
            */
           static fn (iterable $iterable): Generator => yield from new UnpackIterableAggregate($iterable);
    }
}
