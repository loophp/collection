<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Prepend.
 */
final class Prepend extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$items] = $this->parameters;

        return $collection::with(
            static function () use ($items, $collection): \Generator {
                foreach ($items as $item) {
                    yield $item;
                }

                foreach ($collection as $item) {
                    yield $item;
                }
            }
        );
    }
}
