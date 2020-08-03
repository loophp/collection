<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
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
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, int $offset, ?int $length): Generator {
                $skip = (new Run(new Skip($offset)))($iterator);

                if (null === $length) {
                    return yield from $skip;
                }

                return yield from (new Run(new Limit($length)))($skip);
            };
    }
}
