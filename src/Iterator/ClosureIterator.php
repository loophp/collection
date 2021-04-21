<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;

/**
 * @internal
 *
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
     * @param mixed ...$arguments
     * @psalm-param mixed ...$arguments
     * @psalm-param callable(mixed ...):Generator<TKey, T> $callable
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->callable = $callable;
        $this->arguments = $arguments;
        $this->iterator = $this->getGenerator();
    }

    public function rewind(): void
    {
        $this->iterator = $this->getGenerator();
    }

    /**
     * @psalm-return Generator<TKey, T>
     */
    private function getGenerator(): Generator
    {
        return yield from ($this->callable)(...$this->arguments);
    }
}
