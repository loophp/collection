<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function is_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Flatten extends AbstractGeneratorOperation implements Operation
{
    public function __construct(int $depth)
    {
        $this->storage['depth'] = $depth;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<int, T>
             */
            static function (Iterator $iterator, int $depth): Generator {
                foreach ($iterator as $value) {
                    if (false === is_iterable($value)) {
                        yield $value;
                    } elseif (1 === $depth) {
                        /** @psalm-var T $subValue */
                        foreach ($value as $subValue) {
                            yield $subValue;
                        }
                    } elseif (is_array($value)) {
                        /** @psalm-var T $subValue */
                        foreach ((new Run())()(new ArrayIterator($value), new Flatten($depth - 1)) as $subValue) {
                            yield $subValue;
                        }
                    }
                }
            };
    }
}
