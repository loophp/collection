<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;
use OuterIterator;

/**
 * Class IterableIterator.
 *
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @implements Iterator<TKey, T>
 */
final class IterableIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * IterableIterator constructor.
     *
     * @param iterable<TKey, bool|float|int|string|T> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            /**
             * @param iterable<TKey, bool|float|int|string|T> $iterable
             *
             * @return Generator<TKey, bool|float|int|string|T>
             */
            static function (iterable $iterable): Generator {
                foreach ($iterable as $key => $value) {
                    yield $key => $value;
                }
            },
            $iterable
        );
    }
}
