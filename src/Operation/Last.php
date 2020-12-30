<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use EmptyIterator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Last extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Iterator<TKey, T>
             */
            static function (Iterator $iterator): Iterator {
                $isEmpty = true;

                foreach ($iterator as $key => $current) {
                    $isEmpty = false;
                }

                if (true === $isEmpty) {
                    return new EmptyIterator();
                }

                return yield $key => $current;
            };
    }
}
