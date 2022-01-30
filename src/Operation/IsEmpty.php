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
final class IsEmpty extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(iterable<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return static fn (iterable $iterable): Generator => yield !(new IterableIteratorAggregate($iterable))->getIterator()->valid();
    }
}
