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
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Equals extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $other
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, bool>
             */
            static function (Iterator $other): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<int, bool> $pipe */
                $pipe = Pipe::of()(
                    Diff::of()(...$other),
                    IsEmpty::of(),
                );

                // Point free style.
                return $pipe;
            };
    }
}
