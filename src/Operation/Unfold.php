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
final class Unfold extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(T...): Closure(callable(T...): list<T>): Closure(): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$parameters
             *
             * @return Closure(callable(T...): list<T>): Closure(): Generator<int, list<T>>
             */
            static fn (...$parameters): Closure =>
                /**
                 * @param callable(T...): list<T> $callback
                 *
                 * @return Closure(): Generator<int, list<T>>
                 */
                static fn (callable $callback): Closure =>
                    /**
                     * @return Generator<int, list<T>>
                     */
                    static function () use ($parameters, $callback): Generator {
                        while (true) {
                            $parameters = $callback(...$parameters);

                            yield $parameters;
                        }
                    };
    }
}
