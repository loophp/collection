<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Tail extends AbstractOperation implements Operation
{
    public function __construct(?int $length = null)
    {
        $this->storage['length'] = $length ?? 1;
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, int $length): Generator {
            return yield from (
                new Run(
                    new Limit($length)
                ))(
                    (new Run(new Skip(iterator_count($iterator) - $length)))($iterator)
                );
        };
    }
}
