<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;

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
        $this->storage['operations'] = $operations;
    }

    public function __invoke()
    {
        return function (Iterator $collection) {
            return array_reduce(
                $this->get('operations', []),
                static function (Iterator $collection, Operation $operation) {
                    return new ClosureIterator(
                        $operation(),
                        $collection,
                        ...array_values($operation->getArguments())
                    );
                },
                $collection
            );
        };
    }
}
