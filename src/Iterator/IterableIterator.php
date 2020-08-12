<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;
use OuterIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 * @implements \Iterator<TKey, T>
 */
final class IterableIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * @param iterable<mixed> $iterable
     * @psalm-param iterable<TKey, T> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            /**
             * @psalm-param iterable<TKey, T> $iterable
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
