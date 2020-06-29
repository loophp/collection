<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;

final class Shuffle extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            $data = (new All())($collection);

            while ([] !== $data) {
                $randomKey = array_rand($data);
                $randomValue = $data[$randomKey];
                unset($data[$randomKey]);

                yield $randomKey => $randomValue;
            }
        };
    }
}
