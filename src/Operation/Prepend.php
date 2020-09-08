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
final class Prepend extends AbstractOperation
{
    /**
     * @psalm-return Closure(T...): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param T ...$items
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<int|TKey, T>
             */
            static function (...$items): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int|TKey, T>
                     */
                    static function (Iterator $iterator) use ($items): Generator {
                        foreach ($items as $key => $item) {
                            yield $key => $item;
                        }

                        foreach ($iterator as $key => $value) {
                            yield $key => $value;
                        }
                    };
            };
    }
}
