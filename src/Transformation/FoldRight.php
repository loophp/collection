<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;
use loophp\collection\Operation\Reverse;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class FoldRight implements Transformation
{
    /**
     * @var callable
     * @psalm-var callable(T|null, T, TKey):(T|null)
     */
    private $callback;

    /**
     * @var mixed|null
     * @psalm-var T|null
     */
    private $initial;

    /**
     * @psalm-param callable(T|null, T, TKey):(T|null) $callback
     *
     * @param mixed|null $initial
     * @psalm-param T|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->callback = $callback;
        $this->initial = $initial;
    }

    /**
     * @psalm-param iterable<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke(iterable $collection)
    {
        $callback = $this->callback;
        $initial = $this->initial;

        return (new Transform(new FoldLeft($callback, $initial)))((new Run(new Reverse()))($collection));
    }
}
