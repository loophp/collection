<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface BaseCollection.
 */
interface BaseCollection extends \IteratorAggregate, Runable
{
    /**
     * {@inheritdoc}
     *
     * @return \Iterator
     */
    public function getIterator();
}
