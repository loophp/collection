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
final class Head extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>):Generator<TKey, T, mixed, EmptyIterator|mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             *
             * @psalm-return Generator<TKey, T, mixed, EmptyIterator|void>
             */
            static function (Iterator $iterator): Generator {
                $isEmpty = true;

                foreach ($iterator as $key => $current) {
                    $isEmpty = false;

                    break;
                }

                if (true === $isEmpty) {
                    return new EmptyIterator();
                }

                /**
                 * @psalm-var TKey $key
                 * @psalm-var T $current
                 */
                return yield $key => $current;
            };
    }
}
