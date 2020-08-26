<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Merge extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (...$sources): Closure {
            return static function (Iterator $iterator) use ($sources): Generator {
                foreach ($iterator as $key => $value) {
                    yield $key => $value;
                }

                foreach ($sources as $source) {
                    foreach ($source as $key => $value) {
                        yield $key => $value;
                    }
                }
            };
        };
    }
}
