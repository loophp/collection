<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Filter.
 */
final class Filter extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$callbacks] = $this->parameters;

        if ([] === $callbacks) {
            $callbacks[] = static function ($value) {
                return $value;
            };
        }

        return Collection::with(
            static function () use ($callbacks, $collection): \Generator {
                foreach ($callbacks as $callback) {
                    foreach ($collection->getIterator() as $key => $value) {
                        if (true === (bool) $callback($value, $key)) {
                            yield $key => $value;
                        }
                    }
                }
            }
        );
    }
}
