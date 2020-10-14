<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class IntersectKeys extends AbstractOperation
{
    /**
     * @psalm-return Closure(TKey...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param TKey ...$keys
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (...$keys): Closure {
                $filterCallbackFactory = static fn (array $keys): Closure =>
                    /**
                     * @psalm-param T $value
                     * @psalm-param TKey $key
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @param mixed $value
                     * @param mixed $key
                     */
                    static fn ($value, $key, Iterator $iterator): bool => in_array($key, $keys, true);

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()($filterCallbackFactory($keys));

                // Point free style.
                return $filter;
            };
    }
}
