<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @implements Transformation<TKey, T, T|U>
 */
final class Get implements Transformation
{
    /**
     * @var U
     */
    private $default;

    /**
     * @var int|string
     */
    private $key;

    /**
     * Get constructor.
     *
     * @param int|string|TKey $key
     * @param U $default
     */
    public function __construct($key, $default)
    {
        $this->key = $key;
        $this->default = $default;
    }

    /**
     * @param iterable<TKey, T> $collection
     *
     * @return T|U
     */
    public function __invoke(iterable $collection)
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
