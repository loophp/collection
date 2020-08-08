<?php

declare(strict_types=1);

namespace loophp\collection\Contract;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Transformation
{
    public function __invoke();

    /**
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
