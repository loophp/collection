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
final class First implements Transformation
{
    /**
     * @var callable
     * @psalm-var callable(T, TKey):(bool)
     */
    private $callback;

    /**
     * @var mixed|null
     * @psalm-var T|null
     */
    private $default;

    /**
     * @psalm-param callable(T, TKey):(bool)|null $callback
     *
     * @param mixed|null $default
     * @psalm-param T|null $default
     */
    public function __construct(?callable $callback = null, $default = null)
    {
        $this->callback = $callback ?? static function ($key, $value): bool {
            return true;
        };
        $this->default = $default;
    }

    /**
     * @param iterable<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke(iterable $collection)
    {
        $callback = $this->callback;
        $default = $this->default;

        foreach ($collection as $key => $value) {
            if (true === $callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }
}
