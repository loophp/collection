<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Until extends AbstractOperation implements Operation
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
                    yield $key => $value;

                    $result = array_reduce(
                        $callbacks,
                        static function (int $carry, callable $callable) use ($key, $value): int {
                            return $carry & $callable($value, $key);
                        },
                        1
                    );

                    if (1 === $result) {
                        break;
                    }
                }
            };
    }
}
