<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Unwrap extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            foreach ($iterator as $key => $value) {
                foreach ((array) $value as $k => $v) {
                    yield $k => $v;
                }
            }
        };
    }
}
