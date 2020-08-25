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
final class FoldLeft implements Transformation
{
    /**
     * @var callable
     * @psalm-var callable(T|null, T, TKey, \Iterator<TKey, T>):(T|null)
     */
    private $callback;

    /**
     * @var mixed|null
     * @psalm-var T|null
     */
    private $initial;

    /**
     * @psalm-param callable(T|null, T, TKey, \Iterator<TKey, T>):(T|null) $callback
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
     * @psalm-param Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke(Iterator $collection)
    {
        $callback = $this->callback;
        $initial = $this->initial;

        foreach ($collection as $key => $value) {
            $initial = $callback($initial, $value, $key, $collection);
        }

        return $initial;
    }
}
