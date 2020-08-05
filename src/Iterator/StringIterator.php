<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;
use Iterator;
use OuterIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T of string
 *
 * @extends ProxyIterator<TKey, T>
 * @implements \Iterator<TKey, T>
 * @implements \OuterIterator<TKey, T>
 */
final class StringIterator extends ProxyIterator implements Iterator, OuterIterator
{
    public function __construct(string $data, string $delimiter = '')
    {
        $this->iterator = new ClosureIterator(
            /**
             * @psalm-return \Generator<int, string>
             */
            static function (string $input, string $delimiter): Generator {
                $offset = 0;

                $nextOffset = '' !== $delimiter ?
                    mb_strpos($input, $delimiter, $offset) :
                    1;

                while (mb_strlen($input) > $offset && false !== $nextOffset) {
                    yield (string) mb_substr($input, $offset, $nextOffset - $offset);
                    $offset = $nextOffset + mb_strlen($delimiter);

                    $nextOffset = '' !== $delimiter ?
                        mb_strpos($input, $delimiter, $offset) :
                        $nextOffset + 1;
                }

                if ('' !== $delimiter) {
                    yield (string) mb_substr($input, $offset);
                }
            },
            $data,
            $delimiter
        );
    }
}
