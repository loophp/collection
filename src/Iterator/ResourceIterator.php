<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use InvalidArgumentException;
use Iterator;
use loophp\iterators\ClosureIterator;
use ReturnTypeWillChange;

use function is_resource;

/**
 * @internal
 *
 * @implements Iterator<int, string>
 */
final class ResourceIterator implements Iterator
{
    /**
     * @var Iterator<int, string>
     */
    private Iterator $iterator;

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

    #[ReturnTypeWillChange]
    public function current(): string
    {
        return $this->iterator->current();
    }

    /**
     * @return int
     */
    #[ReturnTypeWillChange]
    public function key()
    {
        return $this->iterator->key();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }
}
