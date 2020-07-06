<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @implements Transformation<TKey, T, bool>
 */
final class Contains implements Transformation
{
    /**
     * @var string
     */
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @param iterable<TKey, T> $collection
     */
    public function __invoke(iterable $collection): bool
    {
        $key = $this->key;

        foreach ($collection as $value) {
            if ($value === $key) {
                return true;
            }
        }

        return false;
    }
}
