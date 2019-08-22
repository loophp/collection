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
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$offset, $length] = $this->parameters;

        return static function () use ($offset, $length, $collection): \Generator {
            if (null === $length) {
                yield from (new Skip($offset))->run($collection)();
            } else {
                yield from (new Limit($length))->run($collection::with((new Skip($offset))->run($collection)))();
            }
        };
    }
}
