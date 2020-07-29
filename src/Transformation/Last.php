<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class Last implements Transformation
{
    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /**
             * @param mixed $carry
             * @param mixed $item
             *
             * @return mixed
             */
            static function ($carry, $item) {
                return $item;
            }
        ))($collection);
    }
}
