<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Nth.
 */
final class Nth extends Operation
{
    /**
     * Nth constructor.
     *
     * @param int $step
     * @param int $offset
     */
    public function __construct(int $step, int $offset)
    {
        parent::__construct(...[$step, $offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$step, $offset] = $this->parameters;

        return static function () use ($step, $offset, $collection): \Generator {
            $position = 0;

            foreach ($collection as $key => $item) {
                if ($position++ % $step !== $offset) {
                    continue;
                }

                yield $key => $item;
            }
        };
    }
}
