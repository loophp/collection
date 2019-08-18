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
                $iterators = Collection::with(
                    Collection::with($iterables)
                        ->map(
                            static function ($iterable) {
                                return Collection::with($iterable)->getIterator();
                            }
                        )
                        ->prepend($collection->getIterator())
                );

                while ($iterators->map(static function (\Iterator $iterator) {
                    return $iterator->valid();
                })->contains(true)) {
                    yield Collection::with(
                        $iterators->map(
                            static function (\Iterator $item) {
                                return $item->current();
                            }
                        )
                    )->all();

                    $iterators->apply(
                        static function (\Iterator $item): void {
                            $item->next();
                        }
                    );
                }
            }
        );
    }
}
