<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use InvalidArgumentException;

use function is_resource;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @extends ProxyIterator<int, string>
 */
final class ResourceIterator extends ProxyIterator
{
    /**
     * @param false|resource $resource
     */
    public function __construct($resource, bool $closeResource = false)
    {
        if (!is_resource($resource) || 'stream' !== get_resource_type($resource)) {
            throw new InvalidArgumentException('Invalid resource type.');
        }

        $callback =
            /**
             * @param resource $resource
             *
             * @return Generator<int, string, mixed, void>
             */
            static function ($resource) use ($closeResource): Generator {
                try {
                    while (false !== $chunk = fgetc($resource)) {
                        yield $chunk;
                    }
                } finally {
                    if ($closeResource) {
                        fclose($resource);
                    }
                }
            };

        $this->iterator = new ClosureIterator($callback, [$resource]);
    }
}
