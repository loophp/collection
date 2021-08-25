<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Unfold implements Operation
{
    /**
     * @pure
     *
     * @param T ...$parameters
     *
     * @return Closure(callable(mixed|T...): (mixed|array<TKey, T>)): Closure(): Generator<int, T>
     */
    public function __invoke(...$parameters): Closure
    {
        return
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
                        /** @var T $parameters */
                        $parameters = $callback(...array_values((array) $parameters));

                        yield $parameters;
                    }
                };
    }
}
