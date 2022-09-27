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
final class Key extends AbstractOperation
{
    /**
     * @return Closure(int): Closure(iterable<TKey, T>): Generator<int, TKey>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<int, TKey>
             */
            static function (int $index): Closure {
                /** @var Closure(iterable<TKey, T>): Generator<int, TKey> $pipe */
                $pipe = (new Pipe())()(
                    (new Limit())()(1)($index),
                    (new Flip())()
                );

                // Point free style.
                return $pipe;
            };
    }
}
