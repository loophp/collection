<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class RSample extends AbstractOperation implements Operation
{
    public function __construct(float $probability)
    {
        $this->storage['probability'] = $probability;
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, float $probability): Generator {
            yield from (new Run(
                new Filter(
                    static function () use ($probability): bool {
                        return (mt_rand() / mt_getrandmax()) < $probability;
                    }
                )
            ))($collection);
        };
    }
}
