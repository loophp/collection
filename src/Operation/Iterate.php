<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Iterate extends AbstractOperation implements Operation
{
    /**
     * Iterate constructor.
     *
     * @param array<mixed> $parameters
     * @param callable $callback
     */
    public function __construct(callable $callback, array $parameters = [])
    {
        $this->storage = [
            'callback' => $callback,
            'parameters' => $parameters,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<mixed, mixed> $parameters
             * @param iterable $collection
             * @param callable $callback
             */
            static function (iterable $collection, callable $callback, array $parameters): Generator {
                while (true) {
                    yield $parameters = $callback(...array_values((array) $parameters));
                }
            };
    }
}
