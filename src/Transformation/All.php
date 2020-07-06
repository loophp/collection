<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @implements Transformation<TKey, T, array<TKey, T>>
 */
final class All implements Transformation
{
    /**
     * @param iterable<TKey, T> $collection
     *
     * @return array<TKey, T>
     */
    public function __invoke(iterable $collection): array
    {
        $all = [];

        foreach ($collection as $k => $v) {
            $all[$k] = $v;
        }

        return $all;
    }
}
