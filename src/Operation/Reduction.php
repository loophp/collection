<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Reduction extends AbstractOperation implements Operation
{
    /**
     * Reduction constructor.
     *
     * @param mixed|null $initial
     * @param callable $callback
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->storage = [
            'callback' => $callback,
            'initial' => $initial,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable $collection
             * @param callable $callback
             * @param mixed|null $initial
             */
            static function (iterable $collection, callable $callback, $initial): Generator {
                foreach ($collection as $key => $value) {
                    yield $initial = $callback($initial, $value, $key);
                }
            };
    }
}
