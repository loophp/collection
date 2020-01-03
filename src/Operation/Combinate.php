<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;
use loophp\collection\Transformation\Count;

use function array_slice;
use function count;

/**
 * Class Combinate.
 */
final class Combinate implements Operation
{
    /**
     * @var int|null
     */
    private $length;

    /**
     * Permutations constructor.
     *
     * @param int $length
     */
    public function __construct(?int $length = null)
    {
        $this->length = $length;
    }

    /**
     * @param array<mixed> $dataset
     * @param int $length
     *
     * @return Generator<array<mixed>>
     */
    public function getCombinations(array $dataset, int $length): Generator
    {
        $originalLength = count($dataset);
        $remainingLength = $originalLength - $length + 1;

        for ($i = 0; $i < $remainingLength; ++$i) {
            $current = $dataset[$i];

            if (1 === $length) {
                yield [$current];
            } else {
                $remaining = array_slice($dataset, $i + 1);

                foreach ($this->getCombinations($remaining, $length - 1) as $permutation) {
                    array_unshift($permutation, $current);

                    yield $permutation;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $length = $this->length;

        $getPermutation = function (array $dataset, int $length): Generator {
            return $this->getCombinations($dataset, $length);
        };

        return static function () use ($length, $collection, $getPermutation): Generator {
            $dataset = (new All())->on($collection);

            if (0 < $length) {
                return yield from $getPermutation($dataset, $length);
            }

            $collectionSize = count($dataset);

            if (0 === $length) {
                return yield from $getPermutation($dataset, $collectionSize);
            }

            for ($i = 1; $i <= $collectionSize; ++$i) {
                yield from $getPermutation($dataset, $i);
            }
        };
    }
}
