<?php

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
 */
final class TakeWhile extends AbstractOperation
{
    /**
     * @return Closure(callable(T, TKey, iterable<TKey, T>): bool ...): Closure(iterable<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T, TKey, iterable<TKey, T>): bool ...$callbacks
             *
             * @return Closure(iterable<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<TKey, T>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $callback = CallbacksArrayReducer::or()($callbacks);

                    foreach ($iterable as $key => $current) {
                        if (false === $callback($current, $key, $iterable)) {
                            break;
                        }

                        yield $key => $current;
                    }
                };
    }
}
