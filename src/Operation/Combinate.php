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
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param callable(array<int, T>, int): (array<int, T>) $getCombinations
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, ?int $length, callable $getCombinations): Generator {
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
    }

    /**
     * @param array<mixed> $dataset
     * @psalm-param array<int, T> $dataset
     *
     * @return Generator<array<mixed>>
     * @psalm-return \Generator<array<int, T>>
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
