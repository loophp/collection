<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Reduction extends AbstractOperation implements Operation
{
    /**
     * Reduction constructor.
     *
     * @param mixed|null $initial
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
             * @param mixed|null $initial
             */
            static function (Iterator $iterator, callable $callback, $initial): Generator {
                foreach ($iterator as $key => $value) {
                    yield $initial = $callback($initial, $value, $key);
                }
            };
    }
}
