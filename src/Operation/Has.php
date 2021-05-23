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
 * @template TKey of array-key
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Has extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey, Iterator<TKey, T>): T ...): Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey, Iterator<TKey, T>): T ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, bool>
             */
            static function (callable ...$callbacks): Closure {
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<int|TKey, bool> $pipe */
                $pipe = MatchOne::of()(static fn (): bool => true)(
                    ...array_map(
                        static fn (callable $callback): callable =>
                            /**
                             * @param mixed $value
                             * @psalm-param T $value
                             *
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @psalm-param Iterator<TKey, T> $iterator
                             */
                            static fn ($value, $key, Iterator $iterator): bool => $callback($value, $key, $iterator) === $value,
                        $callbacks
                    )
                );

                // Point free style.
                return $pipe;
            };
    }
}
