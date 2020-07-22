<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use InfiniteIterator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\Operation;

final class Cycle extends AbstractOperation implements Operation
{
    public function __construct(?int $length = null)
    {
        $this->storage['length'] = $length ?? 0;
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, int $length): Generator {
            if (0 === $length) {
                return yield from [];
            }

            yield from new LimitIterator(
                new InfiniteIterator($iterator),
                0,
                $length
            );
        };
    }
}
