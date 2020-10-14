<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use function array_slice;
use function count;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Combinate extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (?int $length = null): Closure {
            $getCombinations =
                /**
                 * @param array<mixed> $dataset
                 * @psalm-param array<int, T> $dataset
                 *
                 * @return Generator<array<mixed>>
                 * @psalm-return Generator<array<int, T>>
                 */
                static function (array $dataset, int $length) use (&$getCombinations): Generator {
                    for ($i = 0; count($dataset) - $length >= $i; ++$i) {
                        if (1 === $length) {
                            yield [$dataset[$i]];

                            continue;
                        }

                        /** @psalm-var array<int, T> $permutation */
                        foreach ($getCombinations(array_slice($dataset, $i + 1), $length - 1) as $permutation) {
                            array_unshift($permutation, $dataset[$i]);

                            yield $permutation;
                        }
                    }
                };

            return
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<int, array<int, T>>
                 */
                static function (Iterator $iterator) use ($length, $getCombinations): Generator {
                    $dataset = [...$iterator];

                    if (0 < $length) {
                        return yield from $getCombinations($dataset, (int) $length);
                    }

                    $collectionSize = count($dataset);

                    if (0 === $length) {
                        return yield from $getCombinations($dataset, $collectionSize);
                    }

                    for ($i = 1; $i <= $collectionSize; ++$i) {
                        yield from $getCombinations($dataset, $i);
                    }
                };
        };
    }
}
