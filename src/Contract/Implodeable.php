<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Implodeable.
 */
interface Implodeable
{
    /**
     * @param string $glue
     *
     * @return string
     */
    public function implode(string $glue = ''): string;
}
