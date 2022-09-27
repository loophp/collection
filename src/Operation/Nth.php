<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Nth extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(int): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(int): Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (int $step): Closure =>
                /**
                 * @return Closure(iterable<TKey, T>): Generator<TKey, T>
                 */
                static function (int $offset) use ($step): Closure {
                    /** @var Closure(iterable<TKey, T>): Generator<TKey, T> $pipe */
                    $pipe = (new Pipe())()(
                        (new Pack())(),
                        (new Filter())()(
                            /**
                             * @param array{0: TKey, 1: T} $value
                             */
                            static fn (array $value, int $key): bool => (($key % $step) === $offset)
                        ),
                        (new Unpack())()
                    );

                    // Point free style.
                    return $pipe;
                };
    }
}
