<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Group extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<int, list<T>>
             */
            static function (Iterator $iterator): Generator {
                $spanCallback =
                    /**
                     * @psalm-param T $current
                     *
                     * @psalm-return Closure(T): bool
                     *
                     * @param mixed $current
                     */
                    static function ($current): Closure {
                        return
                            /**
                             * @psalm-param T $value
                             *
                             * @param mixed $value
                             */
                            static function ($value) use ($current): bool {
                                return $value === $current;
                            };
                    };

                for (; $iterator->valid(); $span->next(), $iterator = $span->current()) {
                    $key = $iterator->key();
                    $current = $iterator->current();

                    /** @psalm-var Iterator<int, Iterator<TKey, T>> $span */
                    $span = Span::of()($spanCallback($current))($iterator);

                    yield $key => iterator_to_array($span->current());
                }
            };
    }
}
