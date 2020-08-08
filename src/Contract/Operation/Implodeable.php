<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

interface Implodeable
{
    public function implode(string $glue = ''): string;
}
