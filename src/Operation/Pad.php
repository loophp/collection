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
     * @param int $size
     * @param mixed $value
     */
    public function __construct(int $size, $value)
    {
        $this->storage = [
            'size' => $size,
            'value' => $value,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param iterable $collection
             * @param int $size
             * @param mixed $padValue
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
