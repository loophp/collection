<?php

declare(strict_types = 1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Pad.
 */
final class Pad extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        [$size, $value] = $this->parameters;

        return $collection::withClosure(
            static function () use ($size, $value, $collection) {
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
