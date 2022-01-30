<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Utils\CallbacksArrayReducer;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Reject extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): bool ...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): bool ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static function (callable ...$callbacks): Closure {
                $defaultCallback =
                    /**
                     * @param T $value
                     */
                    static fn ($value): bool => (bool) $value;

                $callbacks = [] === $callbacks ?
                    [$defaultCallback] :
                    $callbacks;

                $reject = (new Filter())()(
                    /**
                     * @param T $current
                     * @param TKey $key
                     * @param iterable<TKey, T> $iterable
                     */
                    static fn ($current, $key, iterable $iterable): bool => !CallbacksArrayReducer::or()($callbacks, $current, $key, $iterable)
                );

                // Point free style.
                return $reject;
            };
    }
}
