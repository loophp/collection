<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use LimitIterator;
use loophp\collection\Contract\Operation;

final class Limit extends AbstractOperation implements Operation
{
    public function __construct(int $limit, int $offset = 0)
    {
        $this->storage = [
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, int $limit, int $offset): Generator {
            yield from new LimitIterator($iterator, $offset, $limit);
        };
    }
}
