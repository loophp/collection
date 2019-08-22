<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Merge.
 */
final class Merge extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$sources] = $this->parameters;

        return $collection::with(
            static function () use ($sources, $collection): \Generator {
                foreach ($collection as $item) {
                    yield $item;
                }

                foreach ($sources as $source) {
                    foreach ($source as $item) {
                        yield $item;
                    }
                }
            }
        );
    }
}
