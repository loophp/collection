<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Nth.
 */
final class Nth extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$step, $offset] = $this->parameters;

        return Collection::with(
            static function () use ($step, $offset, $collection): \Generator {
                $position = 0;

                foreach ($collection as $key => $item) {
                    if ($position++ % $step !== $offset) {
                        continue;
                    }

                    yield $key => $item;
                }
            }
        );
    }
}
