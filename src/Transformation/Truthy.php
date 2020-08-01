<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class Truthy implements Transformation
{
    public function __invoke(Iterator $collection): bool
    {
        foreach ($collection as $key => $value) {
            if (false === (bool) $value) {
                return false;
            }
        }

        return true;
    }
}
