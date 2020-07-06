<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Merge extends AbstractOperation implements Operation
{
    /**
     * Merge constructor.
     *
     * @param iterable<TKey, T> ...$sources
     */
    public function __construct(iterable ...$sources)
    {
        $this->storage['sources'] = $sources;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, list<iterable<TKey, T>>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param list<iterable<TKey, T>> $sources
             *
             * @return Generator<TKey, T>
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
