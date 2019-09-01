<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Nth.
 */
final class Nth implements Operation
{
    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $step;

    /**
     * Nth constructor.
     *
     * @param int $step
     * @param int $offset
     */
    public function __construct(int $step, int $offset)
    {
        $this->step = $step;
        $this->offset = $offset;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $step = $this->step;
        $offset = $this->offset;

        return static function () use ($step, $offset, $collection): \Generator {
            $position = 0;

            foreach ($collection as $key => $value) {
                if ($position++ % $step !== $offset) {
                    continue;
                }

                yield $key => $value;
            }
        };
    }
}
