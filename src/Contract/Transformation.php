<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

interface Transformation
{
    /**
     * @param iterable<mixed> $collection
     *
     * @return mixed
     */
    public function __invoke(iterable $collection);
}
