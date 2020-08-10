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
final class Run extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $collection, Operation ...$operations) {
            return array_reduce(
                $operations,
                static function (Iterator $collection, Operation $operation) {
                    return ($operation->getWrapper())(
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
