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
final class Merge extends AbstractLazyOperation implements LazyOperation
{
    /**
     * @param iterable<int|string, mixed> ...$sources
     * @psalm-param \Iterator<TKey, T> ...$sources
     */
    public function __construct(iterable ...$sources)
    {
        $this->storage['sources'] = $sources;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<iterable<TKey, T>> $sources
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, array $sources): Generator {
                foreach ($iterator as $key => $value) {
                    yield $key => $value;
                }

                foreach ($sources as $source) {
                    foreach ($source as $key => $value) {
                        yield $key => $value;
                    }
                }
            };
    }
}
