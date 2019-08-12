<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Filter.
 */
final class Filter extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        $callback = $this->parameters[0];

        if (null === $callback) {
            $callback = static function ($value) {
                return $value;
            };
        }

        return $collection::withClosure(
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
