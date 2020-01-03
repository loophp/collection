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
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $length = $this->length;

        $getCombinations = function (array $dataset, int $length): Generator {
            return $this->getCombinations($dataset, $length);
        };

        return static function () use ($length, $collection, $getCombinations): Generator {
            $dataset = (new All())->on($collection);

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
    }

    /**
     * @param array<mixed> $dataset
     * @param int $length
     *
     * @return Generator<array<mixed>>
     */
    private function getCombinations(array $dataset, int $length): Generator
    {
        for ($i = 0; count($dataset) - $length >= $i; ++$i) {
            if (1 === $length) {
                yield [$dataset[$i]];
            } else {
                foreach ($this->getCombinations(array_slice($dataset, $i + 1), $length - 1) as $permutation) {
                    array_unshift($permutation, $dataset[$i]);

                    yield $permutation;
                }
            }
        }
    }
}
