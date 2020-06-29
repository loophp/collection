<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Count;
use loophp\collection\Transformation\Run;

final class Tail extends AbstractOperation implements Operation
{
    public function __construct(int $length = 1)
    {
        $this->storage['length'] = $length;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, int $length): Generator {
            yield from (
                new Run(
                    new Skip(
                        (new Count())($collection) - $length
                    ),
                    new Limit($length)
                ))($collection);
        };
    }
}
