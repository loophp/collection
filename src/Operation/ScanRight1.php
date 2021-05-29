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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class ScanRight1 extends AbstractOperation
{
    /**
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>): (T|null)):Closure (Iterator<TKey, T>): Generator<int|TKey, T|null>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @return Closure(Iterator<TKey, T>): Generator<int|TKey, T|null>
             */
            static function (callable $callback): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T> $pipe */
                $pipe = Pipe::of()(
                    Reverse::of(),
                    ScanLeft1::of()($callback),
                    Reverse::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
