<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;

use function array_slice;
use function count;

final class Combinate extends AbstractOperation implements Operation
{
    public function __construct(?int $length = null)
    {
        $this->storage = [
            'length' => $length,
            'getCombinations' => function (array $dataset, int $length): Generator {
                return $this->getCombinations($dataset, $length);
            },
        ];
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, ?int $length, callable $getCombinations): Generator {
            $dataset = (new All())($collection);

            if (0 < $length) {
                // TODO: Investigate why it's calling issues with PHPStan.
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

                continue;
            }

            foreach ($this->getCombinations(array_slice($dataset, $i + 1), $length - 1) as $permutation) {
                array_unshift($permutation, $dataset[$i]);

                yield $permutation;
            }
        }
    }
}
