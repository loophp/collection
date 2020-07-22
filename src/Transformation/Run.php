<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;

final class Run implements Transformation
{
    /**
     * @var array<int, \loophp\collection\Contract\Operation>
     */
    private $operations;

    public function __construct(Operation ...$operations)
    {
        $this->operations = $operations;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection): ClosureIterator
    {
        $iterableIterator = new IterableIterator($collection);

        return (
            new FoldLeft(
                static function (iterable $collection, Operation $operation) use ($iterableIterator): ClosureIterator {
                    return new ClosureIterator(
                        $operation(),
                        $iterableIterator,
                        ...array_values($operation->getArguments())
                    );
                },
                $collection
            )
        )($this->operations);
    }
}
