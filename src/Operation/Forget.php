<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
final class Forget extends AbstractOperation
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
                     * @param mixed $value
                     * @psalm-param T $value
                     *
                     * @param mixed $key
                     * @psalm-param TKey $key
                     */
                    static fn ($value, $key): bool => false === in_array($key, $keys, true);

                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()($filterCallbackFactory($keys));

                // Point free style.
                return $filter;
            };
    }
}
