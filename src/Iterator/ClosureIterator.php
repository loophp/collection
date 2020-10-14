<?php

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Closure;
use Generator;

/**
 * @psalm-template TKey
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class ClosureIterator extends ProxyIterator
{
    /**
     * @var array<int, mixed>
     * @psalm-var list<mixed>
     */
    private array $arguments;

    /**
     * @var callable
     * @psalm-var callable(mixed ...):Generator<TKey, T>
     */
    private $callable;

    /**
     * @var Closure
     * @psalm-var Closure(callable(mixed ...): Generator<TKey, T>, list<T>):Generator<TKey, T>
     */
    private $generator;

    /**
     * @param mixed ...$arguments
     * @psalm-param mixed ...$arguments
     * @psalm-param callable(mixed ...):Generator<TKey, T> $callable
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->callable = $callable;
        $this->arguments = $arguments;
        $this->generator =
            /**
             * @psalm-param callable(T...):Generator<TKey, T> $callable
             * @psalm-param list<T> $arguments
             */
            static fn (callable $callable, array $arguments): Generator => yield from ($callable)(...$arguments);

        $this->iterator = $this->getGenerator();
    }

    public function rewind(): void
    {
        $this->iterator = $this->getGenerator();
    }

    /**
     * Init the generator if not initialized yet.
     *
     * @psalm-return Generator<TKey, T>
     */
    private function getGenerator(): Generator
    {
        return ($this->generator)($this->callable, $this->arguments);
    }
}
