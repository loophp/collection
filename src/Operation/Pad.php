<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

final class Pad extends AbstractOperation implements Operation
{
    /**
     * Pad constructor.
     *
     * @param mixed $value
     * @param int $size
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
             * @param mixed $padValue
             * @param iterable $collection
             * @param int $size
             */
            static function (iterable $collection, int $size, $padValue): Generator {
                $y = 0;

                foreach ($collection as $key => $value) {
                    ++$y;

                    yield $key => $value;
                }

                while ($y++ < $size) {
                    yield $padValue;
                }
            };
    }
}
