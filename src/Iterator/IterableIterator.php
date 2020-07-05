<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;
use OuterIterator;

/**
 * Class IterableIterator.
 *
 * @implements Iterator<mixed>
 */
final class IterableIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * IterableIterator constructor.
     *
     * @param iterable<mixed> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            static function (iterable $iterable): Generator {
                foreach ($iterable as $key => $value) {
                    yield $key => $value;
                }
            },
            $iterable
        );
    }
}
