<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;
use loophp\collection\Transformation\Run;
use loophp\collection\Transformation\Transform;

final class Reverse extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            $all = (new Transform(new All()))((new Run(new Wrap()))($collection));

            for (end($all); null !== key($all); prev($all)) {
                $item = current($all);

                yield key($item) => current($item);
            }
        };
    }
}
