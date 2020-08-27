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
     * @return Closure(int): Closure(T): Closure(Iterator<TKey, T>): Generator<int|TKey, T>
     */
    public function __invoke(): Closure
    {
        return static function (int $size): Closure {
            return
                /**
                 * @psalm-param T $padValue
                 *
                 * @param mixed $padValue
                 */
                static function ($padValue) use ($size): Closure {
                    return
                        /**
                         * @psalm-param Iterator<TKey, T> $iterator
                         *
                         * @psalm-return Generator<int|TKey, T>
                         */
                        static function (Iterator $iterator) use ($size, $padValue): Generator {
                            $y = 0;

                            foreach ($iterator as $key => $value) {
                                ++$y;

                                yield $key => $value;
                            }

                            while ($y++ < $size) {
                                yield $padValue;
                            }
                        };
                };
        };
    }
}
