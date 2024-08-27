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
     * @return Closure(int...): Closure(iterable<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(iterable<TKey, T>): Generator<int, list<T>>
             */
            static fn (int ...$sizes): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<int, list<T>>
                 */
                static function (iterable $iterable) use ($sizes): Generator {
                    $sizesCount = count($sizes);
                    $i = 0;
                    $values = [];

                    foreach ($iterable as $value) {
                        $size = $sizes[$i % $sizesCount];

                        if (0 >= $size) {
                            return;
                        }

                        if (count($values) !== $size) {
                            $values[] = $value;

                            continue;
                        }

                        ++$i;

                        yield $values;

                        $values = [$value];
                    }

                    if ([] !== $values) {
                        yield $values;
                    }
                };
    }
}
