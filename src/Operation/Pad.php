<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Pad.
 */
final class Pad extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$size, $value] = $this->parameters;

        return Collection::with(
            static function () use ($size, $value, $collection): \Generator {
                $y = 0;

                foreach ($collection->getIterator() as $key => $item) {
                    ++$y;

                    yield $key => $item;
                }

                while ($y++ < $size) {
                    yield $value;
                }
            }
        );
    }
}
