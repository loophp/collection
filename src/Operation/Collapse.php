<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Collapse extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            foreach ($collection as $value) {
                if (true !== is_iterable($value)) {
                    continue;
                }

                foreach ($value as $subValue) {
                    yield $subValue;
                }
            }
        };
    }
}
