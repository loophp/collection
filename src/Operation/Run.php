<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

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
    public function run(BaseCollectionInterface $collection)
    {
        [$operations] = $this->parameters;

        return \array_reduce($operations, [$this, 'doRun'], $collection);
    }

    /**
     * Run an operation on the collection.
     *
     * @param \drupol\collection\Contract\BaseCollection $collection
     *   The collection.
     * @param \drupol\collection\Operation\Operation $operation
     *   The operation.
     *
     * @return mixed
     *   The operation result.
     */
    private function doRun(BaseCollectionInterface $collection, Operation $operation)
    {
        $return = $operation->run($collection);

        if ($return instanceof \Closure) {
            $return = $collection::with($return);
        }

        return $return;
    }
}
