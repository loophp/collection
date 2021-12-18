<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;
use IteratorIterator;
use ReturnTypeWillChange;

/**
 * @internal
 *
 * @implements Iterator<int, string>
 */
final class StringIterator implements Iterator
{
    /**
     * @var Iterator<int, string>
     */
    private Iterator $iterator;

    public function __construct(string $data, string $delimiter = '')
    {
        $callback =
            /**
             * @return Generator<int, string>
             */
            static function (string $input, string $delimiter): Generator {
                $offset = 0;

                while (
                    mb_strlen($input) > $offset
                    && false !== $nextOffset = '' !== $delimiter ? mb_strpos($input, $delimiter, $offset) : 1 + $offset
                ) {
                    yield mb_substr($input, $offset, $nextOffset - $offset);

                    $offset = $nextOffset + mb_strlen($delimiter);
                }

                if ('' !== $delimiter) {
                    yield mb_substr($input, $offset);
                }
            };

        $this->iterator = new IteratorIterator($callback($data, $delimiter));
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
