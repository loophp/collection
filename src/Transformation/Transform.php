<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformer;

/**
 * Class Transform.
 */
final class Transform implements Transformer
{
    /**
     * @var \drupol\collection\Contract\Transformer[]
     */
    private $transformers;

    /**
     * Run constructor.
     *
     * @param \drupol\collection\Contract\Transformer ...$transformers
     */
    public function __construct(Transformer ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        return \array_reduce($this->transformers, [$this, 'doRun'], $collection);
    }

    /**
     * Run an operation on the collection.
     *
     * @param iterable $collection
     *   The collection.
     * @param \drupol\collection\Contract\Transformer $transformer
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(iterable $collection, Transformer $transformer)
    {
        return $transformer->on($collection);
    }
}
