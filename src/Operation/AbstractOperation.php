<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use function array_key_exists;

abstract class AbstractOperation
{
    /**
     * @var array<string, mixed>
     */
    protected $storage = [];

    /**
     * @param mixed|null $default
     * @param string $key
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->storage) ?
            $this->storage[$key] :
            $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array
    {
        return $this->storage;
    }
}
