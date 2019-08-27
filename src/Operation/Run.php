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
    public function on(iterable $collection)
    {
        [$operations] = $this->parameters;

        return \array_reduce($operations, [$this, 'doRun'], $collection);
    }

    /**
     * Run an operation on the collection.
     *
     * @param iterable $collection
     *   The collection.
     * @param \drupol\collection\Operation\Operation $operation
     *   The operation.
     *
     * @throws \ReflectionException
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(iterable $collection, Operation $operation)
    {
        $return = $operation->on($collection);

        if ($return instanceof \Closure) {
            // Todo: Remove this.
            $return = new ClosureIterator($return);
        }

        return $return;
    }
}
