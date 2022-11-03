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
final class FlatMap extends AbstractOperation
{
    /**
     * @template IKey
     * @template IValue
     *
     * @return Closure(callable(T=, TKey=, iterable<TKey, T>=): iterable<mixed, mixed>): Closure(iterable<TKey, T>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T=, TKey=, iterable<TKey, T>=): iterable<mixed, mixed> $callback
             */
            static function (callable $callback): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<IKey, IValue> $flatMap */
                $flatMap = (new Pipe())()(
                    (new Map())()($callback),
                    (new Flatten())()(1),
                );

                // Point free style
                return $flatMap;
            };
    }
}
