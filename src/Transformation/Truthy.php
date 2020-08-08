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
final class Truthy extends AbstractTransformation implements Transformation
{
    public function __invoke()
    {
        return static function (Iterator $collection): bool {
            foreach ($collection as $key => $value) {
                if (false === (bool) $value) {
                    return false;
                }
            }

            return true;
        };
    }
}
