<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Flatten.
 */
final class Flatten extends Operation
{
    /**
     * Flatten constructor.
     *
     * @param int $depth
     */
    public function __construct(int $depth)
    {
        parent::__construct(...[$depth]);
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): \Closure
    {
        [$depth] = $this->parameters;

        return static function () use ($depth, $collection): \Generator {
            foreach ($collection as $item) {
                if (!\is_array($item) && !$item instanceof BaseCollectionInterface) {
                    yield $item;
                } elseif (1 === $depth) {
                    foreach ($item as $i) {
                        yield $i;
                    }
                } else {
                    $flatten = new Flatten($depth - 1);

                    foreach ($collection::with($flatten->run($collection::with($item))) as $flattenItem) {
                        yield $flattenItem;
                    }
                }
            }
        };
    }
}
