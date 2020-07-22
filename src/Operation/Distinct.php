<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

final class Distinct extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            $seen = [];

            foreach ($iterator as $key => $value) {
                if (true === in_array($value, $seen, true)) {
                    continue;
                }

                $seen[] = $value;

                yield $key => $value;
            }
        };
    }
}
