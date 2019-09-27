<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Operation;
use drupol\collection\Contract\Transformation;
use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Run.
 */
final class Run implements Transformation
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
    public function __construct(Operation ...$operations)
    {
        $this->operations = $operations;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $callback = static function (iterable $collection, Operation $operation) {
            return new ClosureIterator($operation->on($collection));
        };

        return (new Reduce($callback, $collection))->on($this->operations);
    }
}
