<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use IteratorIterator;

/**
 * @internal
 *
 * @template TKey
 * @template T of string
 *
 * @extends ProxyIterator<int, string>
 */
final class StringIterator extends ProxyIterator
{
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
}
