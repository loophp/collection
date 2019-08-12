<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Collection;

/**
 * Class Slice.
 */
final class Slice extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(Collection $collection): Collection
    {
        [$offset, $length] = $this->parameters;

        return $collection::withClosure(
            static function () use ($offset, $length, $collection) {
                if (null === $length) {
                    yield from $collection->skip($offset);
                } else {
                    yield from $collection->skip($offset)->limit($length);
                }
            }
        );
    }
}
