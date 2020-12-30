<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use EmptyIterator;
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
                $isEmpty = 1;

                foreach ($iterator as $key => $current) {
                    $isEmpty = 0;
                }

                if (1 === $isEmpty) {
                    return new EmptyIterator();
                }

                return yield $key => $current;
            };
    }
}
