<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

interface Operation
{
    public function __invoke(): Closure;

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array;
}
