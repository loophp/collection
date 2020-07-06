<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;
use OuterIterator;

/**
 * @implements Iterator<mixed>
 */
final class ResourceIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * ResourceIterator constructor.
     *
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $closure =
            /**
             * @param resource $resource
             *
             * @return \Generator<int, string, mixed, void>
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
