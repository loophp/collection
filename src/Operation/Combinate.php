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
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<int, list<T>>>
 * @implements Operation<TKey, T, \Generator<int, list<T>>>
 */
final class Combinate extends AbstractOperation implements Operation
{
    public function __construct(?int $length = null)
    {
        $this->storage = [
            'length' => $length,
            'getCombinations' =>
                /**
                 * @param array<TKey, T> $dataset
                 *
                 * @return Generator<int, list<T>>
                 */
                function (array $dataset, int $length): Generator {
                    return $this->getCombinations($dataset, $length);
                },
        ];
    }

    /**
     * @return Closure(\Iterator<TKey, T>, int|null, callable(list<T>, int)): \Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param callable(list<T>, int): \Generator<int, list<T>> $getCombinations
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

                // When $length === null
                for ($i = 1; $i <= $collectionSize; ++$i) {
                    yield from $getCombinations($dataset, $i);
                }
            };
    }

    /**
     * @param list<T> $dataset
     *
     * @return Generator<int, list<T>>
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
