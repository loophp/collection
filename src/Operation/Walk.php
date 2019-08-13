<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Walk.
 */
final class Walk extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        $callbacks = $this->parameters;

        return Collection::withClosure(
            static function () use ($callbacks, $collection) {
                $callback = static function ($carry, $callback) {
                    return $callback($carry);
                };

                foreach ($collection->getIterator() as $key => $value) {
                    yield $key => array_reduce($callbacks, $callback, $value);
                }
            }
        );
    }
}
