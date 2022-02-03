<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class ScanRight1 extends AbstractOperation
{
    /**
     * @template V
     *
     * @return Closure(callable(mixed, T, TKey, iterable<TKey, T>): mixed): Closure(iterable<TKey, T>): Generator<int|TKey, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|V, T, TKey, iterable<TKey, T>): V $callback
             *
             * @return Closure(iterable<TKey, T>): Generator<int|TKey, T|V>
             */
            static function (callable $callback): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<TKey, T|V> $pipe */
                $pipe = (new Pipe())()(
                    (new Reverse())(),
                    (new ScanLeft1())()($callback),
                    (new Reverse())()
                );

                // Point free style.
                return $pipe;
            };
    }
}
