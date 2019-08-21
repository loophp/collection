<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\BaseCollection as CollectionInterface;

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
        [$iterables] = $this->parameters;

        return Collection::with(
            static function () use ($iterables, $collection): \Generator {
                $getIteratorCallback = static function ($iterable) {
                    return Collection::with($iterable)->getIterator();
                };

                $iterators = Normalize::with()->run(
                    Walk::with([$getIteratorCallback])->run(
                        Append::with(\array_merge([$collection], $iterables))->run(Collection::empty())
                    )
                );

                while (Contains::with(true)->run(Proxy::with('map', 'valid', [])->run($iterators))) {
                    yield Proxy::with('map', 'current', [])->run($iterators);

                    $iterators = Proxy::with('apply', 'next', [])->run($iterators);
                }
            }
        );
    }
}
