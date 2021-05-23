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

/**
 * @template TKey of array-key
 * @template T
 */
final class First extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $head */
        $head = Head::of();

        // Point free style.
        return $head;
    }
}
