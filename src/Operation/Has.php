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
final class Has extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): T ...): Closure(iterable<TKey, T>): Generator<TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): T ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, bool>
             */
            static function (callable ...$callbacks): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<TKey, bool> $pipe */
                $pipe = (new MatchOne())()(static fn (): bool => true)(
                    ...array_map(
                        static fn (callable $callback): callable =>
                            /**
                             * @param T $value
                             * @param TKey $key
                             * @param iterable<TKey, T> $iterable
                             */
                            static fn ($value, $key, iterable $iterable): bool => $callback($value, $key, $iterable) === $value,
                        $callbacks
                    )
                );

                // Point free style.
                return $pipe;
            };
    }
}
