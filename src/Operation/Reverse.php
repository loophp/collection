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
use loophp\fpt\FPT;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Reverse extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T, mixed, void>
     */
    public function __invoke(): Closure
    {
        /** @var callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback */
        $callback = FPT::compose()(
            FPT::nary()(2),
            FPT::flip(),
        )('array_merge');

        /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Pack::of(),
            Reduce::of()($callback)([]),
            Unpack::of(),
        );

        // Point free style.
        return $pipe;
    }
}
