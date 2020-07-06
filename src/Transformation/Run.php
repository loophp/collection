<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Iterator\IterableIterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template V
 * @implements Transformation<TKey, T, ClosureIterator>
 */
final class Run implements Transformation
{
    /**
     * @var list<Operation<TKey, T, U>>
     */
    private $operations;

    /**
     * @param \loophp\collection\Contract\Operation<TKey, T, U> ...$operations
     */
    public function __construct(Operation ...$operations)
    {
        $this->operations = $operations;
    }

    public function __invoke(iterable $collection): ClosureIterator
    {
        $iterableIterator = new IterableIterator($collection);

        return (new FoldLeft(
            /**
             * @param iterable<TKey, T> $collection
             */
            static function (iterable $collection, Operation $operation) use ($iterableIterator): ClosureIterator {
                return new ClosureIterator(
                    $operation(),
                    $iterableIterator,
                    ...array_values($operation->getArguments())
                );
            },
            $collection
        ))($this->operations);
    }
}
