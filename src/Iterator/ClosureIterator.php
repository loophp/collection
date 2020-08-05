<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Closure;
use Generator;
use Iterator;
use OuterIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 * @implements \Iterator<TKey, T>
 * @implements \OuterIterator<TKey, T>
 */
final class ClosureIterator extends ProxyIterator implements Iterator, OuterIterator
{
    /**
     * @var array<int, mixed>
     * @psalm-var list<T>
     */
    private $arguments;

    /**
     * @var callable
     * @psalm-var callable(T...):(\Generator<TKey, T>)
     */
    private $callable;

    /**
     * @var Closure
     * @psalm-var Closure(callable(T...):\Generator<TKey, T>, list<T>):(\Generator<TKey, T>)
     */
    private $generator;

    /**
     * @param mixed ...$arguments
     * @psalm-param T ...$arguments
     * @psalm-param callable(T...):(\Generator<TKey,T>) $callable
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
     * @psalm-return \Generator<TKey, T>
     */
    private function getGenerator(): Generator
    {
        return ($this->generator)($this->callable, $this->arguments);
    }
}
