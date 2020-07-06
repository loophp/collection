<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Shuffle extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                /** @psalm-var list<array<TKey, T>> $data */
                $data = iterator_to_array((new Run(new Wrap()))($iterator));

                while ([] !== $data) {
                    $randomKey = array_rand($data);

                    yield key($data[$randomKey]) => current($data[$randomKey]);
                    unset($data[$randomKey]);
                }
            };
    }
}
