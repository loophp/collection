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
             * @psalm-param T $element
             *
             * @param mixed $element
             */
            static function ($element): Closure {
                return static function (int $atEvery) use ($element): Closure {
                    return static function (int $startAt) use ($element, $atEvery): Closure {
                        return
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

                                foreach ($iterator as $key => $value) {
                                    if (0 === $startAt++ % $atEvery) {
                                        yield $element;
                                    }

                                    yield $key => $value;
                                }
                            };
                    };
                };
            };
    }
}
