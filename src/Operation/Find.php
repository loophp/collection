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
     * @return Closure(V): Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(Iterator<TKey, T>): Generator<TKey, T|V>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param V $valueIfPredicateIsNotMet
             *
             * @return Closure(callable(T=, TKey=, Iterator<TKey, T>=): bool ...): Closure(Iterator<TKey, T>): Generator<TKey, T|V>
             */
            static fn ($valueIfPredicateIsNotMet): Closure =>
            /**
             * @param callable(T=, TKey=, Iterator<TKey, T>=): bool ...$predicates
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T|V>
             */
            static function (callable ...$predicates) use ($valueIfPredicateIsNotMet): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<TKey, T|V> $pipe */
                $pipe = Pipe::of()(
                    Filter::of()(...$predicates),
                    Append::of()($valueIfPredicateIsNotMet),
                    Head::of(),
                );

                // Point free style.
                return $pipe;
            };
    }
}
