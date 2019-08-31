<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Pad.
 */
final class Pad extends Operation
{
    /**
     * Pad constructor.
     *
     * @param int $size
     * @param mixed $value
     */
    public function __construct(int $size, $value)
    {
        parent::__construct(...[$size, $value]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$size, $padValue] = $this->parameters;

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
