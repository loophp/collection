<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Flatten extends AbstractOperation implements Operation
{
    public function __construct(int $depth)
    {
        $this->storage['depth'] = $depth;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, int $depth): Generator {
            foreach ($collection as $value) {
                if (false === is_iterable($value)) {
                    yield $value;
                } elseif (1 === $depth) {
                    foreach ($value as $subValue) {
                        yield $subValue;
                    }
                } else {
                    foreach ((new Run(new Flatten($depth - 1)))($value) as $subValue) {
                        yield $subValue;
                    }
                }
            }
        };
    }
}
