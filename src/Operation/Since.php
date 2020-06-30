<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

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
             * @param iterable $collection
             */
            static function (iterable $collection, array $callbacks): Generator {
                $iterator = new IterableIterator($collection);

                while ($iterator->valid()) {
                    $result = array_reduce(
                        $callbacks,
                        static function (int $carry, callable $callable) use ($iterator): int {
                            return $carry & $callable($iterator->current(), $iterator->key());
                        },
                        1
                    );

                    if (1 === $result) {
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
