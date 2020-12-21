<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InvalidArgumentException;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Intersperse extends AbstractOperation
{
    /**
     * @psalm-return Closure(T): Closure(int): Closure(int): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $element
             * @psalm-param T $element
             *
             * @psalm-return Closure(int): Closure(int): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
             */
            static fn ($element): Closure =>
                /**
                 * @psalm-return Closure(int): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
                 */
                static fn (int $atEvery): Closure =>
                    /**
                     * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, T>
                     */
                    static fn (int $startAt): Closure =>
                        /**
                         * @psalm-param Iterator<TKey, T> $iterator
                         *
                         * @psalm-return Generator<int|TKey, T>
                         */
                        static function (Iterator $iterator) use ($element, $atEvery, $startAt): Generator {
                            if (0 > $atEvery) {
                                throw new InvalidArgumentException(
                                    'The second parameter must be a positive integer.'
                                );
                            }

                            if (0 > $startAt) {
                                throw new InvalidArgumentException(
                                    'The third parameter must be a positive integer.'
                                );
                            }

                            for (; $iterator->valid(); $iterator->next()) {
                                $key = $iterator->key();
                                $current = $iterator->current();

                                if (0 === $startAt++ % $atEvery) {
                                    yield $element;
                                }

                                yield $key => $current;
                            }
                        };
    }
}
