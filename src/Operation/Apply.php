<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Apply extends AbstractOperation implements Operation
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
             * @param iterable $collection
             */
            static function (iterable $collection, array $callbacks): Generator {
                foreach ($collection as $key => $value) {
                    foreach ($callbacks as $callback) {
                        if (true === $callback($value, $key)) {
                            continue;
                        }

                        break;
                    }

                    yield $key => $value;
                }
            };
    }
}
