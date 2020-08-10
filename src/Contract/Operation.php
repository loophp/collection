<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;
use Generator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Operation
{
    public function __invoke(): Closure;

    /**
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null);

    /**
     * @return Generator<int, mixed>
     */
    public function getArguments(): Generator;

    public function getWrapper(): Closure;
}
