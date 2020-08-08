<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use ArrayIterator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Transformation\AbstractTransformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Run extends AbstractTransformation implements Transformation
{
    public function __construct(Operation ...$operations)
    {
        $this->storage['operations'] = new ArrayIterator($operations);
    }

    public function __invoke()
    {
        return static function (Iterator $collection, ArrayIterator $operations) {
            return (new Transform(
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
            ))($operations);
        };
    }
}
