<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Walk.
 */
final class Walk extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $callbacks = $this->parameters;

        return $collection::withClosure(
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
