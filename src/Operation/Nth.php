<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Nth extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(int $step, int $offset)
    {
        $this->storage = [
            'step' => $step,
            'offset' => $offset,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, int $step, int $offset): Generator {
                $position = 0;

                foreach ($iterator as $key => $value) {
                    if ($position++ % $step !== $offset) {
                        continue;
                    }

                    yield $key => $value;
                }
            };
    }
}
