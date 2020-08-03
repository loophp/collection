<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Pad extends AbstractOperation implements Operation
{
    /**
     * @param mixed $value
     * @psalm-param T $value
     */
    public function __construct(int $size, $value)
    {
        $this->storage = [
            'size' => $size,
            'value' => $value,
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param T $padValue
             *
             * @psalm-return \Generator<TKey|int, T>
             *
             * @param mixed $padValue
             */
            static function (Iterator $iterator, int $size, $padValue): Generator {
                $y = 0;

                foreach ($iterator as $key => $value) {
                    ++$y;

                    yield $key => $value;
                }

                while ($y++ < $size) {
                    yield $padValue;
                }
            };
    }
}
