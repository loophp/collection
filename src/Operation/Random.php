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
final class Random extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(int $size)
    {
        $this->storage = [
            'size' => $size,
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
            static function (Iterator $iterator, int $size): Generator {
                return yield from (new Run())()($iterator, new Limit($size), new Shuffle());
            };
    }
}
