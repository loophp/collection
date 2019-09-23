<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;

/**
 * Class Transform.
 */
final class Transform implements Transformation
{
    /**
     * @var \drupol\collection\Contract\Transformation[]
     */
    private $transformers;

    /**
     * Run constructor.
     *
     * @param \drupol\collection\Contract\Transformation ...$transformers
     */
    public function __construct(Transformation ...$transformers)
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
     * @param \drupol\collection\Contract\Transformation $transformer
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(iterable $collection, Transformation $transformer)
    {
        return $transformer->on($collection);
    }
}
