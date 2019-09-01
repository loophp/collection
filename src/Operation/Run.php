<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;
use drupol\collection\Contract\Operation as OperationInterface;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Run.
 */
final class Run implements Operation
{
    /**
     * @var \drupol\collection\Contract\Operation[]
     */
    private $operations;

    /**
     * Run constructor.
     *
     * @param \drupol\collection\Contract\Operation ...$operations
     */
    public function __construct(OperationInterface ...$operations)
    {
        $this->operations = $operations;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        return \array_reduce($this->operations, [$this, 'doRun'], $collection);
    }

    /**
     * Run an operation on the collection.
     *
     * @param iterable $collection
     *   The collection.
     * @param \drupol\collection\Contract\Operation $operation
     *   The operation.
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(iterable $collection, OperationInterface $operation)
    {
        $return = $operation->on($collection);

        if ($return instanceof \Closure) {
            // Todo: Remove this.
            $return = new ClosureIterator($return);
        }

        return $return;
    }
}
