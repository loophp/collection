<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Truthyable
{
    public function truthy(): bool;
}
