<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Zip.
 */
final class Zip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        $iterables = $this->parameters;

        return Collection::withClosure(
            static function () use ($iterables, $collection) {
                $iterators =
                    Collection::empty()
                        ->append($collection, ...$iterables)
                        ->map(
                            static function ($iterable) {
                                return Collection::with($iterable)->getIterator();
                            }
                        );

                $iteratorCurrent = static function (\Iterator $iterator) {
                    return $iterator->current();
                };

                $iteratorIsValid = static function (\Iterator $iterator) {
                    return $iterator->valid();
                };

                $iteratorNext = static function (\Iterator $iterator) {
                    $iterator->next();

                    return $iterator;
                };

                while ($iterators->map($iteratorIsValid)->contains(true)) {
                    yield Collection::with($iterators->map($iteratorCurrent));

                    $iterators = $iterators->map($iteratorNext);
                }
            }
        );
    }
}
