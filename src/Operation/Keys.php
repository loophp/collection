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
 * @template TKey
 * @template T
 */
final class Keys extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<int, TKey>
     */
    public function __invoke(): Closure
    {
        /** @var Closure(Iterator<TKey, T>): Generator<int, TKey> $pipe */
        $pipe = Pipe::of()(
            Flip::of(),
            Normalize::of()
        );

        // Point free style.
        return $pipe;
    }
}
