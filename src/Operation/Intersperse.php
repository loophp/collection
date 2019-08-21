<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Intersperse.
 *
 * Insert a given value between each element of a collection.
 * Indices are not preserved.
 */
final class Intersperse extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$element, $every, $startAt] = $this->parameters;

        if (0 >= $every) {
            throw new \InvalidArgumentException('The parameter must be greater than zero.');
        }

        return Collection::with(
            static function () use ($element, $every, $startAt, $collection): \Generator {
                $i = $startAt;

                foreach ($collection as $key => $value) {
                    if (0 === $i % $every) {
                        yield $element;
                    }

                    yield $value;
                    ++$i;
                }
            }
        );
    }
}
