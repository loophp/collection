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
final class Nullsy implements Transformation
{
    /**
     * @psalm-param iterable<TKey, T|null> $collection
     */
    public function __invoke(iterable $collection): bool
    {
        foreach ($collection as $key => $value) {
            if (null !== $value) {
                return false;
            }
        }

        return true;
    }
}
