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
final class Unzip extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, list<T>>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, list<T>> $iterator
             *
             * @psalm-return Generator<int, list<T>>
             */
            static function (Iterator $iterator): Generator {
                $index = 0;
                $result = [];

                foreach ($iterator as $current) {
                    foreach ($current as $c) {
                        $result[$index++][] = $c;
                    }

                    $index = 0;
                }

                return yield from $result;
            };
    }
}
