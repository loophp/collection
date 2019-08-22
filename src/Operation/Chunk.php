<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Chunk.
 */
final class Chunk extends Operation
{
    /**
     * Chunk constructor.
     *
     * @param int $size
     */
    public function __construct(int $size)
    {
        parent::__construct(...[$size]);
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$size] = $this->parameters;

        if (0 >= $size) {
            return $collection::with();
        }

        return $collection::with(
            static function () use ($size, $collection): \Generator {
                $iterator = $collection->getIterator();

                while ($iterator->valid()) {
                    $values = [];

                    for ($i = 0; $iterator->valid() && $i < $size; $i++, $iterator->next()) {
                        $values[$iterator->key()] = $iterator->current();
                    }

                    yield $collection::with($values);
                }
            }
        );
    }
}
