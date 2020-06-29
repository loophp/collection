<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;

final class Permutate extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        $getPermutations = function (array $dataset): Generator {
            return $this->getPermutations($dataset);
        };

        return static function (iterable $collection) use ($getPermutations): Generator {
            yield from $getPermutations((new All())($collection));
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
