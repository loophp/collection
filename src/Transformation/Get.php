<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Get extends AbstractTransformation implements Transformation
{
    public function __invoke()
    {
        return static function ($keyToGet): Closure {
            return static function ($default) use ($keyToGet): Closure {
                return static function (Iterator $collection) use ($keyToGet, $default) {
                    foreach ($collection as $key => $value) {
                        if ($key === $keyToGet) {
                            return $value;
                        }
                    }

                    return $default;
                };
            };
        };
    }
}
