<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Flatten extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (int $depth): Closure {
            return static function (Iterator $iterator) use ($depth): Generator {
                foreach ($iterator as $key => $value) {
                    if (false === is_iterable($value)) {
                        yield $key => $value;
                    } elseif (1 === $depth) {
                        /** @psalm-var T $subValue */
                        foreach ($value as $subKey => $subValue) {
                            yield $subKey => $subValue;
                        }
                    } else {
                        /** @psalm-var IterableIterator<TKey, T> $flatten */
                        $flatten = (new Flatten())()($depth - 1);

                        foreach ((new Run())()($flatten)(new IterableIterator($value)) as $subKey => $subValue) {
                            yield $subKey => $subValue;
                        }
                    }
                }
            };
        };
    }
}
