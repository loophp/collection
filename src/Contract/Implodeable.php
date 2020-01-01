<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

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
