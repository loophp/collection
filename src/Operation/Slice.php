<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
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

    /**
     * @return Closure(\Iterator<TKey, T>, int, int|null): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T>
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
