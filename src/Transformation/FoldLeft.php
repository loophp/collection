<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template V
 * @implements Transformation<TKey, T, V|U|null>
 */
final class FoldLeft implements Transformation
{
    /**
     * @var callable(U|V|null, T, TKey): V
     */
    private $callback;

    /**
     * @var U|null
     */
    private $initial;

    /**
     * @param callable(U|V|null, T, TKey): V $callback
     * @param U|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->callback = $callback;
        $this->initial = $initial;
    }

    /**
     * @param iterable<TKey, T> $collection
     *
     * @return U|V|null
     */
    public function __invoke(iterable $collection)
    {
        $callback = $this->callback;
        $initial = $this->initial;

        foreach ($collection as $key => $value) {
            $initial = $callback($initial, $value, $key);
        }

        return $initial;
    }
}
