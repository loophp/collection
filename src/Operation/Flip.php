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
final class Flip extends AbstractOperation
{
    /**
     * @return Closure(iterable<TKey, T>): Generator<T, TKey>
     */
    public function __invoke(): Closure
    {
        return (new Associate())()(
            /**
             * @param TKey $key
             * @param T $value
             *
             * @return T
             */
            static fn ($key, $value) => $value
        )(
            /**
             * @param T $value
             * @param TKey $key
             *
             * @return TKey
             */
            static fn ($value, $key) => $key
        );
    }
}
