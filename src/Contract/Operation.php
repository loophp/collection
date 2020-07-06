<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

use Closure;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 */
interface Operation
{
    /**
     * @return \Closure<TKey, T>: \Generator<TKey, T>
     */
    public function __invoke(): Closure;

    /**
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array;
}
