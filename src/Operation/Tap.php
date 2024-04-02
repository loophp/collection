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
final class Tap extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey, iterable<TKey, T>):void ...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, iterable<TKey, T>): void ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure => /**
             * @param iterable<TKey, T> $iterable
             *
             * @return Generator<TKey, T>
             */
            static function (iterable $iterable) use ($callbacks): Generator {
                foreach ($iterable as $key => $value) {
                    foreach ($callbacks as $callback) {
                        $callback($value, $key, $iterable);
                    }

                    yield $key => $value;
                }
            };
    }
}
