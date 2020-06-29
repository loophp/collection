<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use LimitIterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

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
        return static function (iterable $collection, int $limit, int $offset): Generator {
            yield from new LimitIterator(new IterableIterator($collection), $offset, $limit);
        };
    }
}
