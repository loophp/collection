<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Duplicate extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
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
                $stack = [];

                for (; $iterator->valid(); $iterator->next()) {
                    $key = $iterator->key();
                    $current = $iterator->current();

                    if (true === in_array($current, $stack, true)) {
                        yield $key => $current;
                    }

                    $stack[] = $current;
                }
            };
    }
}
