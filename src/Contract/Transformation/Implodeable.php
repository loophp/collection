<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

interface Implodeable
{
    public function implode(string $glue = ''): string;
}
