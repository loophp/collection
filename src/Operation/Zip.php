<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Zip.
 */
final class Zip extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$iterables] = $this->parameters;

        return static function () use ($iterables, $collection): \Generator {
            $getIteratorCallback = static function ($iterable) use ($collection) {
                return $collection::with($iterable)->getIterator();
            };

            $iterators = $collection::with((new Walk($getIteratorCallback))->run(
                $collection::with((new Append(\array_merge([$collection], $iterables)))->run($collection::with()))
            ));

            while ((new Contains(true))->run($collection::with((new Proxy('map', 'valid'))->run($iterators)))) {
                yield $collection::with((new Proxy('map', 'current'))->run($iterators));

                $proxy = new Proxy(
                    'map',
                    static function (\Iterator $i) {
                        $i->next();

                        return $i;
                    }
                );

                $iterators = $collection::with($proxy->run($iterators));
            }
        };
    }
}
