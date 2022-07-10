<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\iterators\PackIterableAggregate;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Pack extends AbstractOperation
{
    /**
     * @return Closure(iterable<mixed, mixed>): Generator<int, array{0: TKey, 1: T}>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable<mixed, mixed> $iterable
             *
             * @return Generator<int, array{0: TKey, 1: T}>
             */
            static fn (iterable $iterable): Generator => yield from new PackIterableAggregate($iterable);
    }
}
