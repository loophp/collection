<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;

final class Reverse extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            $all = (new All())($collection);

            for (end($all); null !== ($key = key($all)); prev($all)) {
                yield $key => current($all);
            }
        };
    }
}
