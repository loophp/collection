<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\EagerOperation;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements EagerOperation<TKey, T>
 */
final class Run extends AbstractEagerOperation implements EagerOperation
{
    public function __invoke(): Closure
    {
        return
            /**
             * @param EagerOperation|\loophp\collection\Contract\LazyOperation|Operation ...$operations
             * @psalm-param \Iterator<TKey, T> $collection
             *
             * @psalm-return T|\Iterator<TKey, T>|scalar|null
             */
            static function (Iterator $collection, Operation ...$operations) {
                return array_reduce(
                    $operations,
                    static function (Iterator $collection, Operation $operation) {
                        return $operation->call(
                            $operation(),
                            $collection,
                            ...$operation->getArguments()
                        );
                    },
                    $collection
                );
            };
    }
}
