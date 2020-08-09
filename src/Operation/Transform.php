<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Transform extends AbstractOperation implements Operation
{
    /**
     * @param \loophp\collection\Contract\Operation<TKey, T> ...$transformers
     */
    public function __construct(Operation ...$transformers)
    {
        $this->storage['transformers'] = $transformers;
    }

    public function __invoke(): Closure
    {
        return function (Iterator $collection) {
            return array_reduce(
                $this->get('transformers', []),
                function (Iterator $collection, Operation $operation) {
                    return ($this->getWrapper())(
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
