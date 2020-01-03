<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;

/**
 * Class Permutate.
 */
final class Permutate implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $getPermutations = function (array $dataset): Generator {
            return $this->getPermutations($dataset);
        };

        return static function () use ($collection, $getPermutations): Generator {
            yield from $getPermutations((new All())->on($collection));
        };
    }

    /**
     * @param array<mixed> $dataset
     *
     * @return Generator<array<mixed>>
     */
    private function getPermutations(array $dataset): Generator
    {
        foreach ($dataset as $key => $firstItem) {
            $remaining = $dataset;

            array_splice($remaining, $key, 1);

            if ([] === $remaining) {
                yield [$firstItem];

                continue;
            }

            foreach ($this->getPermutations($remaining) as $permutation) {
                array_unshift($permutation, $firstItem);

                yield $permutation;
            }
        }
    }
}
