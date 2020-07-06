<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, Generator<TKey, array<int, T>>>
 * @implements Operation<TKey, T, Generator<TKey, array<int, T>>>
 */
final class Transpose extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<TKey, array<int, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return \Generator<TKey, array<int, T>>
             */
            static function (Iterator $iterator): Generator {
                $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

                foreach ($iterator as $collectionItem) {
                    $mit->attachIterator(new IterableIterator($collectionItem));
                }

                foreach ($mit as $key => $value) {
                    yield current($key) => $value;
                }
            };
    }
}
