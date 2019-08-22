<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface BaseCollection.
 */
interface BaseCollection extends \IteratorAggregate
{
    /**
     * {@inheritdoc}
     *
     * @return \Iterator
     */
    public function getIterator();

    /**
     * Create a new collection instance.
     *
     * @param mixed $data
     *
     * @return \drupol\collection\Contract\BaseCollection|\drupol\collection\Contract\Collection
     */
    public static function with($data = []): self;
}
