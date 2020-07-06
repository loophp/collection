<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Operation\Reverse;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template V
 * @implements Transformation<TKey, T, V|U|null>
 */
final class FoldRight implements Transformation
{
    /**
     * @var callable
     * @psalm-var callable(U|V|null, T, TKey): V
     */
    private $callback;

    /**
     * @var mixed
     * @psalm-var U|null
     */
    private $initial;

    /**
     * FoldRight constructor.
     *
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

        /**
         * @var TKey $key
         * @var T $value
         */
        foreach ((new Run(new Reverse()))($collection) as $key => $value) {
            $initial = $callback($initial, $value, $key);
        }

        return $initial;
    }
}
