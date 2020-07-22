<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Permutate extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        $getPermutations = function (array $dataset): Generator {
            return $this->getPermutations($dataset);
        };

        return static function (Iterator $iterator) use ($getPermutations): Generator {
            return yield from $getPermutations(iterator_to_array($iterator));
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
