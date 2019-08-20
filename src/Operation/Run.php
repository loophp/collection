<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Run.
 */
final class Run extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection)
    {
        [$operations] = $this->parameters;

        return \array_reduce($operations, [$this, 'doRun'], $collection);
    }

    /**
     * Run an operation on the collection.
     *
     * @param \drupol\collection\Contract\Collection $collection
     *   The collection.
     * @param \drupol\collection\Operation\Operation $operation
     *   The operation.
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(CollectionInterface $collection, Operation $operation)
    {
        return $operation->run($collection);
    }
}
