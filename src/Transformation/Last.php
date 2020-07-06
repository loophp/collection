<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @implements Transformation<TKey, T, T>
 */
final class Last implements Transformation
{
    /**
     * @param iterable<TKey, T> $collection
     *
     * @return T
     */
    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /**
             * @param null $initial
             * @param T $value
             * @param TKey $key
             *
             * @return T
             */
            static function ($initial, $value, $key) {
                return $value;
            },
            null
        ))($collection);
    }
}
