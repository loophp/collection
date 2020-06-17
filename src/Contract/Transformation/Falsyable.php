<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Falsyable
{
    /**
     * @return bool
     */
    public function falsy(): bool;
}
