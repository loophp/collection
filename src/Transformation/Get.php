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
final class Get implements Transformation
{
    /**
     * @var mixed
     * @psalm-var T
     */
    private $default;

    /**
     * @var int|string
     */
    private $key;

    /**
     * @param int|string $key
     * @param mixed $default
     * @psalm-param T $default
     */
    public function __construct($key, $default)
    {
        $this->key = $key;
        $this->default = $default;
    }

    /**
     * @param Iterator<TKey, T> $collection
     *
     * @return T
     */
    public function __invoke(Iterator $collection)
    {
        $keyToGet = $this->key;
        $default = $this->default;

        foreach ($collection as $key => $value) {
            if ($key === $keyToGet) {
                return $value;
            }
        }

        return $default;
    }
}
