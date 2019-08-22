<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Append.
 */
final class Append extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$items] = $this->parameters;

        return static function () use ($items, $collection): \Generator {
            foreach ($collection as $item) {
                yield $item;
            }

            foreach ($items as $item) {
                yield $item;
            }
        };
    }
}
