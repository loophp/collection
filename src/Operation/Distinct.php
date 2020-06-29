<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

use function in_array;

final class Distinct extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            $seen = [];

            foreach ($collection as $key => $value) {
                if (true === in_array($value, $seen, true)) {
                    continue;
                }

                $seen[] = $value;

                yield $key => $value;
            }
        };
    }
}
