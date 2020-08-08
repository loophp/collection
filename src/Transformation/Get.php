<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Transformation;
use loophp\collection\Transformation\AbstractTransformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Get extends AbstractTransformation implements Transformation
{
    /**
     * @param int|string $key
     * @param mixed $default
     * @psalm-param T $default
     */
    public function __construct($key, $default)
    {
        $this->storage['key'] = $key;
        $this->storage['default'] = $default;
    }

    public function __invoke()
    {
        return static function (Iterator $collection, $keyToGet, $default) {
            foreach ($collection as $key => $value) {
                if ($key === $keyToGet) {
                    return $value;
                }
            }

            return $default;
        };
    }
}
