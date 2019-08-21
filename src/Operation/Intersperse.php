<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

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
    public function run(\IteratorAggregate $collection): \IteratorAggregate
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
