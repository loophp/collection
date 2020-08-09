<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;

abstract class AbstractOperation
{
    /**
     * @var array<string, mixed>
     */
    protected $storage = [];

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
            return ($callable)(...$arguments);
        };
    }
}
