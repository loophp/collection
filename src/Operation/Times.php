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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Times extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(null|callable(int): T): Closure(null|Iterator<TKey, T>): Generator<int, int|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(null|callable(int): int|T): Closure(null|Iterator<TKey, T>): Generator<int, int|T>
             */
            static function (int $number = 0): Closure {
                return
                    /**
                     * @psalm-return Closure(null|Iterator<TKey, T>): Generator<int, int|T>
                     */
                    static function (?callable $callback = null) use ($number): Closure {
                        return
                            /**
                             * @psalm-param null|Iterator<TKey, T> $iterator
                             *
                             * @psalm-return Generator<int, int|T>
                             */
                            static function (?Iterator $iterator = null) use ($number, $callback): Generator {
                                if (1 > $number) {
                                    throw new InvalidArgumentException('Invalid parameter. $number must be greater than 1.');
                                }

                                $callback = $callback ?? static function (int $value): int {
                                    return $value;
                                };

                                for ($current = 1; $current <= $number; ++$current) {
                                    yield $callback($current);
                                }
                            };
                    };
            };
    }
}
