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
final class Last extends AbstractOperation
{
    /**
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                if (!$iterator->valid()) {
                    return yield from [];
                }

                $key = $iterator->key();
                $current = $iterator->current();

                for (; $iterator->valid(); $iterator->next()) {
                    $key = $iterator->key();
                    $current = $iterator->current();
                }

                return yield $key => $current;
            };
    }
}
