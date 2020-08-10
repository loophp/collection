<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Operation
{
    public function __invoke(): Closure;

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array;
}
