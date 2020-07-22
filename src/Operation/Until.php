<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
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
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                foreach ($iterator as $key => $value) {
                    yield $key => $value;

                    $result = array_reduce(
                        $callbacks,
                        static function (bool $carry, callable $callable) use ($key, $value): bool {
                            return ($callable($value, $key)) ?
                                $carry :
                                false;
                        },
                        true
                    );

                    if (true === $result) {
                        break;
                    }
                }
            };
    }
}
