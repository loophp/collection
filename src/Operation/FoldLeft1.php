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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class FoldLeft1 extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>):(T|null)): Closure(Iterator<TKey, T>): Generator<int|TKey, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @return Closure(Iterator<TKey, T>): Generator<int|TKey, null|T>
             */
            static function (callable $callback): Closure {
                /** @var Closure(Iterator<TKey, T>):(Generator<int|TKey, T|null>) $pipe */
                $pipe = Pipe::of()(
                    ScanLeft1::of()($callback),
                    Last::of()
                );

                // Point free style.
                return $pipe;
            };
    }
}
