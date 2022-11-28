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
final class Forget extends AbstractOperation
{
    /**
     * @return Closure(TKey...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param TKey ...$keys
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static function (mixed ...$keys): Closure {
                return (new Filter())()(
                    /**
                     * @param T $value
                     * @param TKey $key
                     */
                    static fn (mixed $value, mixed $key): bool => !in_array($key, $keys, true)
                );
            };
    }
}
