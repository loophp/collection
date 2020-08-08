<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

interface Truthyable
{
    public function truthy(): bool;
}
