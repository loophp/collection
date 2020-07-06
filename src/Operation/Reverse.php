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
final class Reverse extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): (\Generator<TKey|null, T>)
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey|null, T>
             */
            static function (Iterator $iterator): Generator {
                /** @var array<int, array<TKey, T>> $all */
                $all = iterator_to_array((new Run(new Wrap()))($iterator));

                for (end($all); null !== key($all); prev($all)) {
                    $item = current($all);

                    yield key($item) => current($item);
                }
            };
    }
}
