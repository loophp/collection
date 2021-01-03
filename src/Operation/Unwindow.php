<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Unwindow extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, list<T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(Iterator<TKey, list<T>>): Generator<TKey, T> $unwindow */
        $unwindow = Map::of()(
            /**
             * @psalm-param iterable<TKey, list<T>> $iterable
             *
             * @psalm-return T
             */
            static function (iterable $iterable) {
                foreach ($iterable as $value) {
                }

                return $value;
            }
        );

        // Point free style.
        return $unwindow;
    }
}
