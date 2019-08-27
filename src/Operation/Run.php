<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Run.
 */
final class Run extends Operation
{
    /**
     * Run constructor.
     *
     * @param \drupol\collection\Contract\Operation ...$operations
     */
    public function __construct(\drupol\collection\Contract\Operation ...$operations)
    {
        parent::__construct(...[$operations]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection)
    {
        $collection = clone $collection;

        [$operations] = $this->parameters;

        return \array_reduce($operations, [$this, 'doRun'], $collection);
    }

    /**
     * Run an operation on the collection.
     *
     * @param \Traversable $collection
     *   The collection.
     * @param \drupol\collection\Operation\Operation $operation
     *   The operation.
     *
     * @throws \ReflectionException
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(\Traversable $collection, Operation $operation)
    {
        $collection = clone $collection;

        $return = $operation->on($collection);

        if ($return instanceof \Closure) {
            // Todo: Remove this.
            $return = new ClosureIterator($return);
        }

        return $return;
    }
}
