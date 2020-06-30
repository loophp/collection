<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CallbackFilterIterator;
use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

final class Filter extends AbstractOperation implements Operation
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

                foreach ($callbacks as $callback) {
                    $iterator = new CallbackFilterIterator($iterator, $callback);
                }

                yield from $iterator;
            };
    }
}
