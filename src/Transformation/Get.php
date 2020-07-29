<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
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
     * @param iterable<TKey, T> $collection
     *
     * @return T
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
