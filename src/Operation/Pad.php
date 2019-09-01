<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Pad.
 */
final class Pad implements Operation
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Pad constructor.
     *
     * @param int $size
     * @param mixed $value
     */
    public function __construct(int $size, $value)
    {
        $this->size = $size;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $size = $this->size;
        $padValue = $this->value;

        return static function () use ($size, $padValue, $collection): \Generator {
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
