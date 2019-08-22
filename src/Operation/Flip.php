<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Flip.
 */
final class Flip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        return $collection::with(
            static function () use ($collection): \Generator {
                foreach ($collection as $key => $value) {
                    yield $value => $key;
                }
            }
        );
    }
}
