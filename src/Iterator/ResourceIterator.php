<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use InvalidArgumentException;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class ResourceIterator extends ProxyIterator
{
    /**
     * @param resource $resource
     */
    public function __construct($resource)
    {
        if ('stream' !== get_resource_type($resource)) {
            throw new InvalidArgumentException('Invalid resource type.');
        }

        $closure =
            /**
             * @param resource $resource
             *
             * @psalm-return Generator<int, string>
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
