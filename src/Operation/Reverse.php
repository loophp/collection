<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Reverse extends AbstractLazyOperation implements LazyOperation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey|null, T, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var \Iterator<TKey, T> $newIterator */
                $newIterator = (new Run())()($iterator, new Wrap());
                $all = iterator_to_array($newIterator);

                for (end($all); null !== key($all); prev($all)) {
                    $item = current($all);

                    yield key($item) => current($item);
                }
            };
    }
}
