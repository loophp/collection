<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

final class Slice extends AbstractOperation implements Operation
{
    public function __construct(int $offset, ?int $length = null)
    {
        $this->storage = [
            'offset' => $offset,
            'length' => $length,
        ];
    }

    public function __invoke(): Closure
    {
        return static function (iterable $collection, int $offset, ?int $length): Generator {
            $skip = new Skip($offset);

            if (null === $length) {
                return yield from (new Run($skip))($collection);
            }

            yield from (new Run($skip, new Limit($length)))($collection);
        };
    }
}
