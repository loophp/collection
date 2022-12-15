<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use function in_array;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class IntersectKeys extends AbstractOperation
{
    /**
     * @return Closure(array<TKey>): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param array<TKey> $keys
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (array $keys): Closure => (new Filter())()(
                /**
                 * @param T $value
                 * @param TKey $key
                 */
                static fn (mixed $value, mixed $key): bool => in_array($key, $keys, true)
            );
    }
}
