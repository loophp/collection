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
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$iterables] = $this->parameters;

        return $collection::with(
            static function () use ($iterables, $collection): \Generator {
                $getIteratorCallback = static function ($iterable) use ($collection) {
                    return $collection::with($iterable)->getIterator();
                };

                $iterators = (new Walk($getIteratorCallback))->run(
                    (new Append(\array_merge([$collection], $iterables)))->run($collection::with())
                );

                while ((new Contains(true))->run((new Proxy('map', 'valid'))->run($iterators))) {
                    yield (new Proxy('map', 'current'))->run($iterators);
                    $iterators = (new Proxy('map', static function (\Iterator $i) {
                        $i->next();

                        return $i;
                    }))->run($iterators);
                }
            }
        );
    }
}
