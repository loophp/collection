<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use ArrayIterator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class Run implements Transformation
{
    /**
     * @var ArrayIterator<int, \loophp\collection\Contract\Operation>
     */
    private $operations;

    public function __construct(Operation ...$operations)
    {
        $this->operations = new ArrayIterator($operations);
    }

    public function __invoke(Iterator $collection): Iterator
    {
        return (
            new FoldLeft(
                static function (Iterator $collection, Operation $operation): ClosureIterator {
                    return new ClosureIterator(
                        $operation(),
                        $collection,
                        ...array_values($operation->getArguments())
                    );
                },
                $collection
            )
        )($this->operations);
    }
}
