<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Current extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure(Iterator<TKey, T>): T
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param int $index
             *
             * @psalm-return Closure(Iterator<TKey, T>): T
             */
            static function (int $index): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return T
                     */
                    static function (Iterator $iterator) use ($index) {
                        for ($i = 0; $i < $index; $i++, $iterator->next()) {
                        }

                        return yield $iterator->current();
                    };
            };
    }
}
