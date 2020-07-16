<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Compact extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            return yield from
            (new Run(
                new Filter(
                    static function ($item): bool {
                        return null !== $item;
                    }
                )
            )
            )($collection);
        };
    }
}
