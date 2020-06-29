<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Split extends AbstractOperation implements Operation
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
                $carry = [];

                foreach ($collection as $key => $value) {
                    $carry[] = $value;

                    foreach ($callbacks as $callback) {
                        if (true !== $callback($value, $key)) {
                            continue;
                        }

                        yield $carry;

                        $carry = [];
                    }
                }

                if ([] !== $carry) {
                    yield $carry;
                }
            };
    }
}
