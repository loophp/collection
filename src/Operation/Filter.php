<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

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
        $callback = $this->parameters[0];

        if (null === $callback) {
            $callback = static function ($value) {
                return $value;
            };
        }

        return Collection::with(
            static function () use ($callback, $collection) {
                foreach ($collection->getIterator() as $key => $value) {
                    if (true === (bool) $callback($value, $key)) {
                        yield $key => $value;
                    }
                }
            }
        );
    }
}
