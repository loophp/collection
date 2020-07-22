<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Walk extends AbstractOperation implements Operation
{
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, callable> $callbacks
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    // Custom array_reduce function with the key passed in argument.
                    foreach ($callbacks as $callback) {
                        $value = $callback($value, $key);
                    }

                    yield $key => $value;
                }
            };
    }
}
