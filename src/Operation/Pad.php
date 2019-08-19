<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Pad.
 */
final class Pad extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$size, $value] = $this->parameters;

        return Collection::with(
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
