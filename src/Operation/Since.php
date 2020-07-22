<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Since extends AbstractOperation implements Operation
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
                while ($iterator->valid()) {
                    $result = array_reduce(
                        $callbacks,
                        static function (bool $carry, callable $callable) use ($iterator): bool {
                            return ($callable($iterator->current(), $iterator->key())) ?
                                $carry :
                                false;
                        },
                        true
                    );

                    if (true === $result) {
                        break;
                    }

                    $iterator->next();
                }

                for (; $iterator->valid(); $iterator->next()) {
                    yield $iterator->key() => $iterator->current();
                }
            };
    }
}
