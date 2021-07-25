<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Permutate extends AbstractOperation
{
    /**
     * @pure
     */
    public function __invoke(): Closure
    {
        $getPermutations =
            /**
             * @param list<T> $dataset
             *
             * @return Generator<int, list<T>>
             */
            fn (array $dataset): Generator => $this->getPermutations($dataset);

        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, list<T>>
             */
            static fn (Iterator $iterator): Iterator => $getPermutations([...$iterator]);
    }

    /**
     * @param list<T> $dataset
     *
     * @return Generator<int, list<T>>
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
                // TODO: Fix this.
                array_unshift($permutation, $firstItem);

                yield $permutation;
            }
        }
    }
}
