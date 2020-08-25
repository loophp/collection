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
final class Nullsy implements Transformation
{
    /**
     * @psalm-param Iterator<TKey, T|null> $collection
     */
    public function __invoke(Iterator $collection): bool
    {
        foreach ($collection as $key => $value) {
            if (null !== $value) {
                return false;
            }
        }

        return true;
    }
}
