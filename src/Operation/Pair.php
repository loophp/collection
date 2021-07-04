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
final class Pair extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<T, T|null>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, T>): Generator<T|TKey, T> $pipe */
        $pipe = Pipe::of()(
            Chunk::of()(2),
            Map::of()(
                FPT::compose()(
                    'array_values',
                    FPT::arg()(0)
                )
            ),
            Associate::of()(
                FPT::compose()(
                    'current',
                    FPT::arg()(2)
                )
            )(
                FPT::compose()(
                    'end',
                    FPT::arg()(2)
                )
            )
        );

        // Point free style.
        return $pipe;
    }
}
