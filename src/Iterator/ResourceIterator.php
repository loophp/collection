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
 * @implements Iterator<TKey, T>
 */
final class ResourceIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $closure =
            /**
             * @param resource $resource
             *
             * @psalm-return Generator<int, T>
             */
            static function ($resource): Generator {
                while (false !== $chunk = fgetc($resource)) {
                    yield $chunk;
                }
            };

        $this->iterator = new ClosureIterator(
            $closure,
            $resource
        );
    }
}
