<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function array_slice;
use function count;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Combinate extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (?int $length): Closure {
            $getCombinations = static function (array $dataset, int $length) use (&$getCombinations): Generator {
                for ($i = 0; count($dataset) - $length >= $i; ++$i) {
                    if (1 === $length) {
                        yield [$dataset[$i]];

                        continue;
                    }

                    foreach ($getCombinations(array_slice($dataset, $i + 1), $length - 1) as $permutation) {
                        array_unshift($permutation, $dataset[$i]);

                        yield $permutation;
                    }
                }
            };

            return static function (Iterator $iterator) use ($length, $getCombinations): Generator {
                $dataset = iterator_to_array($iterator);

                if (0 < $length) {
                    return yield from $getCombinations($dataset, $length);
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
