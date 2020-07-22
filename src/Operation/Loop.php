<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Loop extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            foreach (new InfiniteIterator($iterator) as $key => $value) {
                yield $key => $value;
            }
        };
    }
}
