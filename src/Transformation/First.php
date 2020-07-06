<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template V
 * @implements Transformation<TKey, T, T|V|null>
 */
final class First implements Transformation
{
    /**
     * @var callable(T, TKey): bool | callable(): bool
     */
    private $callback;

    /**
     * @var V|null
     */
    private $default;

    /**
     * First constructor.
     *
     * @param null|\Closure(TKey, T): bool|callable(TKey, T): bool $callback
     * @param V|null $default
     */
    public function __construct(?callable $callback = null, $default = null)
    {
        $this->callback = $callback ??
            static function (): bool {
                return true;
            };
        $this->default = $default;
    }

    /**
     * @param iterable<TKey, T> $collection
     *
     * @return T|V|null
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
