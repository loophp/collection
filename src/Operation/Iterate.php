<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Iterate extends AbstractOperation implements Operation
{
    /**
     * Iterate constructor.
     *
     * @param array<mixed> $parameters
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
             */
            static function (Iterator $iterator, callable $callback, array $parameters): Generator {
                while (true) {
                    yield $parameters = $callback(...array_values((array) $parameters));
                }
            };
    }
}
