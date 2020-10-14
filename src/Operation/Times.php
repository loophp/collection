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
            static fn (int $number = 0): Closure =>
                /**
                 * @psalm-return Closure(null|Iterator<TKey, T>): Generator<int, int|T>
                 */
                static fn (?callable $callback = null): Closure =>
                    /**
                     * @psalm-param null|Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, int|T>
                     */
                    static function (?Iterator $iterator = null) use ($number, $callback): Generator {
                        if (1 > $number) {
                            yield from [];
                        }

                        $callback ??= static fn (int $value): int => $value;

                        for ($current = 1; $current <= $number; ++$current) {
                            yield $callback($current);
                        }
                    };
    }
}
