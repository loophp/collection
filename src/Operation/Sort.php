<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Sort.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Sort extends Operation
{
    /**
     * Sort constructor.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        parent::__construct(...[$callback]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$callback] = $this->parameters;

        return static function () use ($callback, $collection): \Generator {
            $array = \iterator_to_array($collection);

            \uasort($array, $callback);

            yield from $array;
        };
    }
}
