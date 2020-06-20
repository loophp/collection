<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use function array_key_exists;

abstract class AbstractOperation
{
    /**
     * @var array
     */
    protected $storage = [];

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->storage) ?
            $this->storage[$key] :
            $default;
    }

    public function getArguments(): array
    {
        return $this->storage;
    }
}
