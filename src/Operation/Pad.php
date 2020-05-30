<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

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
    public function __invoke(): Closure
    {
        $size = $this->size;
        $padValue = $this->value;

        return static function (iterable $collection) use ($size, $padValue): Generator {
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
