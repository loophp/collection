<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Transformer.
 */
interface Transformer
{
    /**
     * @param iterable $collection
     *
     * @return bool|mixed
     */
    public function on(iterable $collection);
}
