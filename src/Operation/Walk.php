<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Walk.
 */
final class Walk extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$callbacks] = $this->parameters;

        return Collection::with(
            static function () use ($callbacks, $collection): \Generator {
                $callback = static function ($carry, $callback) {
                    return $callback($carry);
                };

                foreach ($collection->getIterator() as $key => $value) {
                    yield $key => \array_reduce($callbacks, $callback, $value);
                }
            }
        );
    }
}
