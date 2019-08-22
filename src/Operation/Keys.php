<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Keys.
 */
final class Keys extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        return $collection::with(
            static function () use ($collection): \Generator {
                foreach ($collection as $key => $value) {
                    yield $key;
                }
            }
        );
    }
}
