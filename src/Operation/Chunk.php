<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;

use function count;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Chunk extends AbstractOperation
{
    /**
     * @return Closure(int...): Closure(iterable<TKey, T>): Generator<int, non-empty-list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<int, non-empty-list<T>>
             */
            static fn (int ...$sizes): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int, non-empty-list<T>>
                 */
                static function (iterable $iterable) use ($sizes): Generator {
                    $sizesCount = count($sizes);
                    $chunkIndex = 0;
                    $chunk = [];

                    foreach ($iterable as $value) {
                        $size = $sizes[$chunkIndex % $sizesCount];

                        if (0 >= $size) {
                            return;
                        }

                        if (count($chunk) !== $size) {
                            $chunk[] = $value;

                            continue;
                        }

                        ++$chunkIndex;

                        /** @psalm-var non-empty-list $chunk */

                        yield $chunk;

                        $chunk = [$value];
                    }

                    if ([] !== $chunk) {
                        yield $chunk;
                    }
                };
    }
}
