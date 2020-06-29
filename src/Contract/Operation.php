<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

interface Operation
{
    public function __invoke(): Closure;

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null);

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array;
}
