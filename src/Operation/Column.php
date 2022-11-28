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
final class Column extends AbstractOperation
{
    /**
     * @return Closure(mixed): Closure(iterable<TKey, T>): Generator<int, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<int, mixed>
             */
            static function (mixed $column): Closure {
                $filterCallbackBuilder =
                    /**
                     * @param T $value
                     * @param TKey $key
                     */
                    static fn (mixed $value, mixed $key): bool => $key === $column;

                /** @var Closure(iterable<TKey, T>): Generator<int, mixed> $pipe */
                $pipe = (new Pipe())()(
                    (new Transpose())(),
                    (new Filter())()($filterCallbackBuilder),
                    (new Head())(),
                    (new Flatten())()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
