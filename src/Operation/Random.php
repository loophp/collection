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
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Random extends AbstractOperation implements Operation
{
    public function __construct(int $size = 1)
    {
        $this->storage = [
            'size' => $size,
        ];
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, int $size): Generator {
            yield from (new Run(new Limit($size)))((new Run(new Shuffle()))($iterator));
        };
    }
}
