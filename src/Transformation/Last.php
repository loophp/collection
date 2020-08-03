<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Last implements Transformation
{
    /**
     * @param Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke(Iterator $collection)
    {
        return (new FoldLeft(
            /**
             * @param mixed $carry
             * @psalm-param null|T $carry
             *
             * @param mixed $item
             * @psalm-param T $item
             *
             * @param mixed $key
             * @psalm-param TKey $key
             *
             * @return mixed
             * @psalm-return T
             */
            static function ($carry, $item, $key) {
                return $item;
            }
        ))($collection);
    }
}
