<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Zip.
 */
final class Zip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$iterables] = $this->parameters;

        return Collection::with(
            static function () use ($iterables, $collection): \Generator {
                $iterators =
                    Collection::empty()
                        ->append($collection, ...$iterables)
                        ->map(
                            static function ($iterable) {
                                return Collection::with($iterable)->getIterator();
                            }
                        );

                while ($iterators->proxy('map', 'valid')->contains(true)) {
                    yield $iterators->proxy('map', 'current');

                    $iterators = $iterators->proxy('apply', 'next');
                }
            }
        );
    }
}
