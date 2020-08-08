<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

interface Falsyable
{
    public function falsy(): bool;
}
