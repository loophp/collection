<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;
use loophp\collection\Transformation\Count;

use function count;

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
        $getPermutate = function (array $dataset): Generator {
            return $this->getPermutations($dataset);
        };

        return static function () use ($collection, $getPermutate): Generator {
            yield from $getPermutate((new All())->on($collection));
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

            if (0 === count($remaining)) {
                yield [$firstItem];

                continue;
            }

            foreach ($this->getPermutations($remaining) as $Permutate) {
                array_unshift($Permutate, $firstItem);

                yield $Permutate;
            }
        }
    }
}
