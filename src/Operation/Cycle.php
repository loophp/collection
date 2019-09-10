<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Cycle.
 */
final class Cycle implements Operation
{
    /**
     * @var int
     */
    private $count;

    /**
     * Cycle constructor.
     *
     * @param int $count
     */
    public function __construct(int $count = 0)
    {
        $this->count = $count;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $count = $this->count;

        return static function () use ($collection, $count) {
            for ($j = 0 === $count ? 1 : 0; $j !== $count; ++$j) {
                foreach ($collection as $value) {
                    yield $value;
                }
            }
        };
    }
}
