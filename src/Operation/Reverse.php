<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Reverse extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            $all = iterator_to_array((new Run(new Wrap()))($iterator));

            for (end($all); null !== key($all); prev($all)) {
                $item = current($all);

                yield key($item) => current($item);
            }
        };
    }
}
