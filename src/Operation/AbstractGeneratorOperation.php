<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use loophp\collection\Iterator\ClosureIterator;

use function array_key_exists;

abstract class AbstractGeneratorOperation
{
    /**
     * @var array<string, mixed>
     */
    protected $storage = [];

    /**
     * @param mixed|null $default
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

    public function getWrapper(): Closure
    {
        return static function (callable $callable, ...$arguments) {
            return new ClosureIterator($callable, ...$arguments);
        };
    }
}
