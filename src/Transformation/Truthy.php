<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @implements Transformation<TKey, T, bool>
 */
final class Truthy implements Transformation
{
    /**
     * @param iterable<TKey, T> $collection
     */
    public function __invoke(iterable $collection): bool
    {
        foreach ($collection as $key => $value) {
            if (false === (bool) $value) {
                return false;
            }
        }

        return true;
    }
}
