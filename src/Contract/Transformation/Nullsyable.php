<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Nullsyable
{
    /**
     * @return bool
     */
    public function nullsy(): bool;
}
