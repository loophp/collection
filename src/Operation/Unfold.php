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
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Unfold extends AbstractOperation
{
    /**
     * @return Closure(T...): Closure(callable(mixed|T...): (mixed|array<TKey, T>)): Closure(): Generator<int, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$parameters
             *
             * @return Closure(callable(mixed|T...): (array<TKey, T>)): Closure(): Generator<int, T>
             */
            static fn (...$parameters): Closure =>
                /**
                 * @param callable(mixed|T...): (mixed|array<TKey, T>) $callback
                 *
                 * @return Closure(): Generator<int, T>
                 */
                static fn (callable $callback): Closure =>
                    /**
                     * @return Generator<int, T>
                     */
                    static function () use ($parameters, $callback): Generator {
                        while (true) {
                            /** @psalm-var T $parameters */
                            $parameters = $callback(...array_values((array) $parameters));

                            yield $parameters;
                        }
                    };
    }
}
