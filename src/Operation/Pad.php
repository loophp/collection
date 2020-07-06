<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<TKey|int, T|U>>
 * @implements Operation<TKey, T, Generator<TKey|int, T|U>>
 */
final class Pad extends AbstractOperation implements Operation
{
    /**
     * Pad constructor.
     *
     * @param U $value
     */
    public function __construct(int $size, $value)
    {
        $this->storage = [
            'size' => $size,
            'value' => $value,
        ];
    }

    /**
     * @return Closure(\Iterator<TKey, T>, int, U):Generator<TKey|int, T|U>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param U $padValue
             *
             * @return Generator<int|TKey, T|U>
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
