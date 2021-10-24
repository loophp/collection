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
final class Find extends AbstractOperation
{
    /**
     * @pure
     *
     * @template V
     *
     * @return Closure(V|null): Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(Iterator<TKey, T>): Generator<TKey, T|V|null>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param V|null $default
             *
             * @return Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(Iterator<TKey, T>): Generator<TKey, T|V|null>
             */
            static fn ($default): Closure =>
                /**
                 * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$callbacks
                 *
                 * @return Closure(Iterator<TKey, T>): Generator<TKey, T|V>
                 */
                static function (callable ...$callbacks) use ($default): Closure {
                    /** @var Closure(Iterator<TKey, T>): Generator<TKey, T|V|null> $pipe */
                    $pipe = Pipe::of()(
                        Filter::of()(...$callbacks),
                        Append::of()($default),
                        Head::of(),
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
