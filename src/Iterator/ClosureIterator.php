<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Closure;
use Generator;
use Iterator;
use OuterIterator;

/**
 * Class ClosureIterator.
 *
 * @implements Iterator<mixed>
 */
final class ClosureIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * @var array<int, mixed>
     */
    private $arguments;

    /**
     * @var callable
     */
    private $callable;

    /**
     * @var Closure
     */
    private $generator;

    /**
     * ClosureIterator constructor.
     *
     * @param mixed ...$arguments
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->callable = $callable;
        $this->arguments = $arguments;
        $this->generator = static function (callable $callable, array $arguments): Generator {
            return yield from ($callable)(...$arguments);
        };

        $this->iterator = $this->getGenerator();
    }

    public function rewind(): void
    {
        $this->iterator = $this->getGenerator();
    }

    /**
     * Init the generator if not initialized yet.
     *
     * @return Generator<Generator<mixed>>
     */
    private function getGenerator(): Generator
    {
        return ($this->generator)($this->callable, $this->arguments);
    }
}
