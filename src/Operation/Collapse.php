<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T|list<T>>>
 * @implements Operation<TKey, T, \Generator<TKey, T|list<T>>>
 */
final class Collapse extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<int, T|list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, list<T>|T>
             */
            static function (Iterator $iterator): Generator {
                foreach ($iterator as $value) {
                    if (true !== is_iterable($value)) {
                        continue;
                    }

                    /**
                     * @var TKey $subKey
                     * @var T $subValue
                     */
                    foreach ($value as $subKey => $subValue) {
                        yield $subKey => $subValue;
                    }
                }
            };
    }
}
