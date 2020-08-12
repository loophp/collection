<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Slice extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(int $offset, ?int $length = null)
    {
        $this->storage = [
            'offset' => $offset,
            'length' => $length,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, int $offset, ?int $length): Generator {
                /** @psalm-var \Iterator<TKey, T> $skip */
                $skip = (new Run())()(
                    $iterator,
                    new Skip($offset)
                );

                if (null === $length) {
                    return yield from $skip;
                }

                return yield from (new Run())()($skip, new Limit($length));
            };
    }
}
