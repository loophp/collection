<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Forget.
 */
final class Forget extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection): CollectionInterface
    {
        [$keys] = $this->parameters;

        return Collection::with(
            static function () use ($keys, $collection): \Generator
            {
                $keys = \array_flip($keys);

                foreach ($collection->getIterator() as $key => $value) {
                    if (!\array_key_exists($key, $keys)) {
                        yield $key => $value;
                    }
                }
            }
        );
    }
}
