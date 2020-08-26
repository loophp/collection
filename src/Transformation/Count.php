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
final class Count implements Transformation
{
    public function __invoke()
    {
        return static function (Iterator $iterator): int {
            return iterator_count($iterator);
        };
    }
}
