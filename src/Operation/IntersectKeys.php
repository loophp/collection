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
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($keys): Generator {
                        $filterCallbackFactory = static function (array $keys): Closure {
                            return
                                /**
                                 * @psalm-param T $value
                                 * @psalm-param TKey $key
                                 * @psalm-param Iterator<TKey, T> $iterator
                                 *
                                 * @param mixed $value
                                 * @param mixed $key
                                 */
                                static function ($value, $key, Iterator $iterator) use ($keys): bool {
                                    return in_array($key, $keys, true);
                                };
                        };

                        /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $filter */
                        $filter = Filter::of()($filterCallbackFactory($keys));

                        return $filter($iterator);
                    };
            };
    }
}
