<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

final class Pad extends AbstractOperation implements Operation
{
    /**
     * Pad constructor.
     *
     * @param mixed $value
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
