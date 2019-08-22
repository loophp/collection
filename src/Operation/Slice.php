<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Slice.
 */
final class Slice extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$offset, $length] = $this->parameters;

        return $collection::with(
            static function () use ($offset, $length, $collection): \Generator {
                if (null === $length) {
                    yield from (new Skip($offset))->run($collection);
                } else {
                    yield from (new Limit($length))->run((new Skip($offset))->run($collection));
                }
            }
        );
    }
}
